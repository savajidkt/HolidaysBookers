<?php

namespace App\Http\Controllers\Admin\Orders;

use Dompdf\Dompdf;
use Dompdf\Options;


use App\Models\Order;
use App\Models\Reach;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use App\Http\Requests\Order\EditRequest;
use Yajra\DataTables\Facades\DataTables;


class OrdersController extends Controller
{

    /**
     * orderRepository
     *
     * @var mixed
     */
    protected $orderRepository;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository       = $orderRepository;
    }


    /**
     * Method index
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Order::select('*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('package_id', function (Order $order) {
                    return $order->package_id;
                })
                ->editColumn('hotel_id', function (Order $order) {
                    return $order->hotel->hotel_name;
                })
                ->editColumn('hotel_city_id', function (Order $order) {
                    return $order->city->name;
                })
                ->editColumn('status', function (Order $order) {
                    return $order->status_name;
                })
                ->editColumn('created_at', function (Order $order) {
                    return dateFormat($order->created_at, 'd M, Y');
                })
                ->editColumn('check_in_date', function (Order $order) {
                    return dateFormat($order->check_in_date, 'd M, Y');
                })
                ->editColumn('check_out_date', function (Order $order) {
                    return dateFormat($order->check_out_date, 'd M, Y');
                })
                ->editColumn('guest_lead', function (Order $order) {
                    return $order->guest_lead;
                })
                ->editColumn('cancelled_date', function (Order $order) {
                    return dateFormat($order->cancelled_date, 'd M, Y');
                })
                ->editColumn('total_rooms', function (Order $order) {
                    return $order->total_rooms;
                })
                ->editColumn('total_nights', function (Order $order) {
                    return $order->total_nights;
                })
                ->editColumn('payment', function (Order $order) {
                    return $order->payment_name;
                })

                ->addColumn('action', function (Order $order) {
                    return $order->action;
                })
                ->rawColumns(['action', 'status', 'payment'])->make(true);
        }

        return view('admin.order.index', ['user' => $user]);
    }



    /**
     * Method show
     *
     * @param Request $request [explicite description]
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function show(Order $order)
    {

        return view('admin.order.view', ['model' => $order]);
    }

    public function updatePayment(EditRequest $request, Order $order)
    {
        $this->orderRepository->updatePayment($request->all(), $order);
        return redirect()->route('orders.show', $request->order_id)->with('success', "Order updated successfully!");
    }


    /**
     * Method edit
     *
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function edit(Order $order)
    {
        return view('admin.order.edit', ['model' => $order]);
    }

    /**
     * Method update
     *
     * @param Request $request [explicite description]
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function update(Request $request, Order $order)
    {
        if ($request->action == "order") {
            $this->orderRepository->update($request->all(), $order);
        } else if ($request->action == "passenger") {
            $this->orderRepository->updatePassenger($request->all(), $order);
        }

        return redirect()->route('orders.edit', $order->id)->with('success', "Order updated successfully!");
    }

    /**
     * Method destroy
     *
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function destroy(Order $order)
    {
        $this->orderRepository->delete($order);
        return redirect()->route('orders.index')->with('success', "Order deleted successfully!");
    }


    /**
     * Method orderInvoice
     *
     * @param Order $order [explicite description]
     *
     * @return void
     */

    public function orderInvoice(Order $order)
    {
        return view('admin.order.invoice', ['model' => $order]);
    }
    public function orderInvoiceDownload(Order $order)
    {
        $contenidoDinamico = "Prueba";
        $dompdf = new Dompdf();
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $htmlTemplate = '
		<style>
			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 12px;
				line-height: 20px;
				font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
				color: #555;
			}
			.invoice-box table {
				width: 100%;
				line-height: inherit;
				text-align: left;
			}
			.invoice-box table td {
				padding: 2px;
				vertical-align: top;
			}
			.invoice-box table tr td:nth-child(2) {
				text-align: right;
			}
			.invoice-box table tr.top table td {
				padding-bottom: 10px;
			}
			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}
			.invoice-box table tr.information table td {
				
				padding-bottom: 0px;
			}
			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}
			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}
			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}
			.invoice-box table tr.item.last td {
				border-bottom: none;
			}
			.invoice-box table tr.total td:nth-child(2) {
				
			}
			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}
				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
			/** RTL **/
			.invoice-box.rtl {
				direction: rtl;
				font-family: Tahoma, "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
			}
			.invoice-box.rtl table {
				text-align: right;
			}
			.invoice-box.rtl table tr td:nth-child(2) {
				text-align: left;
			}

            .text-left {
				text-align: left !important;
			}
            .text-center {
				text-align: center !important;
			}
            .text-right {
				text-align: right !important;
			}
            .pt-98 {
				padding-top: 98px !important;
			}
            .font-10 {
				font-size: 10px !important;
			}
            
		</style>
	</head>
	<body>
    
   
		<div class="invoice-box">
			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="' . url('/public/app-assets/images/logo/HBPdfLogo.png') . '" />
								</td>
								<td>
                                (w)www.holidaysbookers.com<br />
                                (e)accounts@holidaysbookers.com
								</td>
							</tr>
						</table>
					</td>
				</tr>
				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
                                <strong>HOLIDAYS BOOKERS DMC INDIA PVT LTD</strong><br />
                                39A Ground Floor, Sarvodya School,<br />
                                Aya Nagar, New Delhi 110047<br />
                                State: Delhi (State Code: 07), Country: India.<br />
                                (P) +91 1148015307/ +91 1142268354 (M) +91 9810560003/+91 991056000<br />
                                (PAN) AAECH3953Q (CIN) U63030DL2017PTC327553 (GSTIN) 07AAECH3953Q1Z0
								</td>								
							</tr>
						</table>
					</td>
				</tr>		
			</table>
            <hr class="my-2">
            <table cellpadding="0" cellspacing="0">				
            <tr class="information">
            <td colspan="2">
                <table>
                    <tr>
                        <td>
                            To,<br />
                            Aisa<br />
                            (Agent Code) CA225940<br />
                            Email: tanush@yopmail.com<br />
                            Mo: +91 8524126321<br />
                            Guest Name: Sachin k<br />
                            Travel Date: 22 Dec 2022 To 27 Dec 2022<br />
                        </td>
                        <td>                            
                                Invoice Number:	INV7224<br />
                                Invoice Date:	24 Apr 2023<br />
                                PNR No.:	7224<br />
                                Deadline Date:	22 Dec 2022
                        </td>
                    </tr>
                </table>
            </td>
        </tr>		
			</table>
            <hr class="my-2">
            <table cellpadding="0" cellspacing="0">			
				
				<tr class="heading">
					<td>PARTICULAR</td>
					<td class="text-center">NIGHT</td>
					<td class="text-center">ROOM</td>
					<td class="text-center">PERSON</td>
					<td class="text-right">TOTAL</td>					
				</tr>				
				<tr class="item">
					<td>GRAND MIRAGE (hotel)</td>
					<td class="text-center">5.00</td>
					<td class="text-center">12</td>
					<td class="text-center">12</td>
					<td class="text-right">5750.00</td>
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Subtotal:<strong> 5750.00</strong></td>
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Discount:<strong> 0.00</strong></td>
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Tax:<strong> 0.00 (%)</strong></td>
				</tr>
				<tr class="total">
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="text-right">Total:<strong> 5750.00 </strong></td>
				</tr>
			</table>
            <hr class="my-2">
            <table cellpadding="0" cellspacing="0">				
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td>
                                <strong>Terms :</strong><br />
                                # Subject to New Delhi jurisdiction.<br />
                                # Without original invoice no refund is permissible.<br />
                                # Interest @ 24% will be charged on delayed payment. # Cheque to be drawn in favour of "company name".<br />
                                # Kindly check all details carefully to avoid un-necessary complications.
                                </td>                       
                            </tr>
                        </table>
                    </td>
                </tr>		
			</table>
            <hr class="my-2">
            <table cellpadding="0" cellspacing="0">				
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="pt-98">                               
                               
                                Receiver\'s Signature
                                </td>                       
                                <td>
                                <strong>for HOLIDAYS BOOKERS DMC INDIA PVT LTD</strong><br />
                                <img src="data:image/jpg;base64,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" width="59" height="58">
                                <p>Authorized Signatory</p>                                
                                </td>                       
                            </tr>
                        </table>
                    </td>
                </tr>		
			</table>
            <hr class="my-2">
            <table cellpadding="0" cellspacing="0">				
                <tr class="information">
                    <td colspan="2">
                        <table>
                            <tr>
                                <td class="text-left font-10"> 
                                (Prepared by: HOLIDAY BOOKERS)                              
                                </td>                       
                                <td class="text-left font-10"> 
                                This is a Computer generated document and does not require any signature.                             
                                </td>                       
                                <td class="text-right font-10"> 
                                (ID: 803)                              
                                </td>                       
                            </tr>
                        </table>
                    </td>
                </tr>		
			</table>
		</div>
	</body>
</html>
';
        $dompdf->loadHtml($htmlTemplate);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        return $dompdf->stream();
    }

    /**
     * Method orderVoucher
     *
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function orderVoucher(Order $order)
    {
        return view('admin.order.voucher', ['model' => $order]);
    }
    /**
     * Method orderItinerary
     *
     * @param Order $order [explicite description]
     *
     * @return void
     */
    public function orderItinerary(Order $order)
    {
        return view('admin.order.itinerary', ['model' => $order]);
    }
}
