<?php

namespace App\Http\Controllers\Agent;

use App\Exports\ExportOrders;
use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Order;
use App\Models\Freebies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\OrderHotelRoom;
use App\Models\OrderHotelRoomPassenger;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\HotelListingRepository;
use Maatwebsite\Excel\Facades\Excel;

class BookingHistoryController extends Controller
{

    public function index(Request $request, $status = "all")
    {
        $pagename = "booking-history";

        if ($request->ajax()) {
            $isDraft = false;
            $user = auth()->user();
            if ($status == "all") {
                $data = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('order_type', 1);
            } else if ($status == "paid") {
                $data = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('payment_status', 1)->where('order_type', 1);
            } else if ($status == "unpaid") {
                $data = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('payment_status', 0)->where('order_type', 1);
            
            } else {
                $data = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('status', orderStatusByID(strtolower($status)))->where('order_type', 1);
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function (Order $order) {
                    return dateFormat($order->created_at, 'd M, Y');
                })
                ->editColumn('is_pay_using', function (Order $order) {
                    return paymentMethodName($order->is_pay_using);
                })
                ->editColumn('passenger_type', function (Order $order) {                    
                    return $order->passenger_type_name;
                })
                ->addColumn('pax', function (Order $order) {
                    return 'Room : ' . $order->total_rooms . ' Adult : ' . $order->total_adult . '<br> Children : ' . $order->total_child.'<br> Night : '.$order->total_nights;
                })
                ->editColumn('booking_amount', function (Order $order) {
                    return getNumberWithCommaGlobalCurrency($order->booking_amount);
                })
                ->editColumn('status', function (Order $order) use ($isDraft) {
                    return getPaymentStatus($order->status);
                })
                ->addColumn('action', function (Order $order)  use ($isDraft) {    
                    return getOrderHistoryAction($order->id, $order);
                })
                ->rawColumns(['action', 'status', 'pax'])->make(true);
        }
        return view('agent.booking-history.index', ['pagename' => $pagename, 'status' => $status]);
    }

    public function show($id)
    {
        $pagename = "view-booking-history";
        $Order = Order::find($id);
        if ($Order) {           

            return view('agent.booking-history.view', ['pagename' => $pagename, 'order' => $Order]);
        }
        return redirect()->route('home');
    }

    public function orderInvoiceDownload(Order $order)
    {


        $guest_lead = $order->lead_passenger_name;
        if ($order->passenger_type == 1) {
            $order_hotel_room = OrderHotelRoomPassenger::where('order_id', 1)->where('is_adult', 0)->first();
            $guest_lead = $order_hotel_room->name;
        }
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
                                    <a href="http://www.holidaysbookers.com" target="_blank">(w)www.holidaysbookers.com</a><br />
                                    <a href="mailto:accounts@holidaysbookers.com" target="_blank">(e)accounts@holidaysbookers.com</a>
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
                            ' . $order->agentcode->user->first_name . ' ' . $order->agentcode->user->last_name . '<br />
                            (Agent Code) ' . $order->agent_code . '<br />
                            Email: ' . $order->agentcode->user->email . '<br />
                            Mobile: ' . $order->agentcode->user->usermeta->phone_number . '<br />
                            Guest Name: ' . $guest_lead . '<br />                            
                        </td>
                        <td>                            
                                Invoice Number:	' . $order->invoice_no . '<br />
                                Invoice Date:	'.date('d M, Y', strtotime($order->created_at)).'<br />                               
                        </td>
                    </tr>
                </table>
            </td>
        </tr>		
			</table>
            <hr class="my-2">
            ' . $this->orderTableCreate($order) . '
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
        $filename = "invoice-" . $order->agent_code . "-download";
        return $dompdf->stream($filename . ".pdf");
    }

    public function orderTableCreate($order)
    {

        $subTotal = 0;
        $total = 0;
        $tax = 0;
        $taxAmt = 0;
        $discount = 0;

        
        $tableStr = '';
        $tableStr .= '<table cellpadding="0" cellspacing="0">';
        $tableStr .= '<tr class="heading">';
        $tableStr .= '<td>HOTEL</td>';
        $tableStr .= '<td class="text-center">NIGHT</td>';
        $tableStr .= '<td class="text-center">ROOM</td>';
        $tableStr .= '<td class="text-center">ADULT</td>';
        $tableStr .= '<td class="text-center">CHILD</td>';
        $tableStr .= '<td class="text-right">TOTAL</td>';
        $tableStr .= '</tr>';
        $tableStr .= '';
        if ($order->order_hotel) {
            $tax = $order->tax;
            $taxAmt = $order->tax_amount;
            foreach ($order->order_hotel as $key => $value) {
                $order_hotel_room = OrderHotelRoom::where('order_hotel_id', $value->id)->first();
            $tableStr .= '<tr class="item">';
                $tableStr .= '<td class="">' . $value->hotel_name . '</td>';
                $tableStr .= '<td class="text-center">' . (int) dateDiffInDays($order_hotel_room->check_in_date, $order_hotel_room->check_out_date) . '</td>';
                $tableStr .= '<td class="text-center">1</td>';
                $tableStr .= '<td class="text-center">' . $order_hotel_room->adult . '</td>';
                $tableStr .= '<td class="text-center">' . $order_hotel_room->child . '</td>';
            $tableStr .= '<td class="text-right"></td>';
            $tableStr .= '</tr>';

                $tableStr .= '<tr>';
                $tableStr .=  '<td><ul style="margin: 0px !important;"><li style="font-size:12px;">' . $order_hotel_room->room_name . '<br> From ' . date('d M, Y', strtotime($order_hotel_room->check_in_date)) . ' To ' . date('d M, Y', strtotime($order_hotel_room->check_out_date)) . ' </li></ul></td>';
                $tableStr .= '<td class="text-center"></td>';
                $tableStr .= '<td class="text-center"></td>';
                $tableStr .= '<td class="text-center"></td>';
                $tableStr .= '<td class="text-center"></td>';
                $tableStr .= '<td class="text-right" style="font-family: DejaVu Sans; sans-serif;">' . getNumberWithCommaGlobalCurrency($order_hotel_room->price) . '</td>';
                $tableStr .= '</tr>';
                $subTotal = $subTotal + $order_hotel_room->price;
            }

            $tableStr .= '<tr class="total">';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td class="text-right">Subtotal: <strong style="font-family: DejaVu Sans; sans-serif;">' . getNumberWithCommaGlobalCurrency($subTotal) . '</strong></td>';
            $tableStr .= '</tr>';

            $tableStr .= '<tr class="total">';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td class="text-right">Discount: <strong style="font-family: DejaVu Sans; sans-serif;">' . getNumberWithCommaGlobalCurrency($discount) . '</strong></td>';
            $tableStr .= '</tr>';

            $tableStr .= '<tr class="total">';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td class="text-right">Tax ('.$tax.'%):<strong style="font-family: DejaVu Sans; sans-serif;"> ' . getNumberWithCommaGlobalCurrency($taxAmt) . '</strong></td>';
            $tableStr .= '</tr>';

            $total = ($subTotal + $taxAmt) - $discount;

            $tableStr .= '<tr class="total">';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td></td>';
            $tableStr .= '<td class="text-right">Total:<strong style="font-family: DejaVu Sans; sans-serif;">' . getNumberWithCommaGlobalCurrency($total) . '</strong></td>';
            $tableStr .= '</tr>';
        }
        $tableStr .= '</table>';
        return $tableStr;
    }


    public function orderCancel($id)
    {
        $user = auth()->user();
        $Order = Order::where('id', $id)->where('agent_code', $user->agents->agent_code)->first();

        if ($Order) {
            $OrderHotelRoom = OrderHotelRoom::where('order_id', $Order->id)->where('id', $_GET['orde_room_id'])->first();
            if ($OrderHotelRoom) {

                $dataSave = [
                    'user_id'        => $user->id,
                    'agent_id'        => $user->agents->id,
                    'transaction_type'     => 'Cancel Order Item',
                    'pnr'     => $Order->prn_number,
                    'amount'     => $OrderHotelRoom->price,
                    'type'     => '1',
                    'comment'     => 'Cancel Order Hotel Room Order ID#' . $Order->id . ' Hotel ID#' . $OrderHotelRoom->order_hotel_id . ' And Room ID#' . $OrderHotelRoom->id,
                ];
                $WalletTransaction = WalletTransaction::where('user_id', $user->id)->where('agent_id', $user->agents->id)->orderBy('created_at', 'desc')->first();
                if ($WalletTransaction) {
                    $dataSave['balance'] =  $WalletTransaction->balance + $OrderHotelRoom->price;
                }                
                WalletTransaction::create($dataSave);
                $booking_amount = $Order->booking_amount - $OrderHotelRoom->price;
                Order::where('id', $Order->id)
                    ->update(['booking_amount' => $booking_amount]);
                OrderHotelRoom::where('id', $OrderHotelRoom->id)->delete();
                OrderHotelRoomPassenger::where('order_id', $Order->id)->where('order_hotel_room_id', $OrderHotelRoom->id)->delete();

                return redirect()->back()->with('success', 'Cancel successfully!');
            } else {
                return redirect()->back()->with('error', 'Cancel failed!');
            }
        }
        return redirect()->back()->with('error', 'Cancel failed!');
    }

    public function exportSingleOrder(Order $Order)
    {

        return Excel::download(new ExportOrders($Order), 'order.csv');        
    }

    public function exportOrders(Request $request)
    {
        echo "all";
}

    public function getCustom($id)
    {
        echo "jj";
        dd($id);
        exit;
    }

    public function orderVoucherDownload(Order $order)
    {
        // $guest_lead = $order->lead_passenger_name;
        // if ($order->passenger_type == 1) {
        // $order_hotel_room = OrderHotelRoomPassenger::where('order_id', 1)->where('is_adult', 0)->first();
        // $guest_lead = $order_hotel_room->name;
        // }
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
                                        <img src="https://hbsingapore.co.in/public/assets/front/img/general/logo-dark.png" />
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
                                    Hotel<br />
                                    Taj Holiday Village Resort and Spa, Goa<br />                            
                                    VIVANTA BY TAJ - HOLIDAY VILLAGE GOA, SINQUERIM, BARDEZ, North Goa, Goa, 403515, GOA<br />                            
                                    (403515).<br />                            
                                    State: Goa (State Code: 30), Country: India.<br />                            
                                    ((M) 832 6480442/9962985892<br />                            
                                </td>
                                <td>                            
                                    Hotel Voucher <br />
                                    HTV00000504 <br />                               
                                    20 Oct 2023<br />                               
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
                                         Test  Test <br />
                                        (Agent Code)  0000052 <br />
                                        Email:  test@gmail.com <br />
                                        Mobile:  987987554544 <br />
                                        Guest Name:  Testing <br />                            
                                    </td>
                                    <td>                            
                                        Invoice Number:  52052 <br />
                                        Invoice Date:    10/10/2023 <br />                               
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <hr class="my-2">
                
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
                                        <img src="data:image/jpg;base64,/9j/4AAQSkZJRgABAQEAYABgAAD/2wBDAAMCAgMCAgMDAwMEAwMEBQgFBQQEBQoHBwYIDAoMDAsKCwsNDhIQDQ4RDgsLEBYQERMUFRUVDA8XGBYUGBIUFRT/2wBDAQMEBAUEBQkFBQkUDQsNFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBQUFBT/wAARCAA6ADsDASIAAhEBAxEB/8QAHwAAAQUBAQEBAQEAAAAAAAAAAAECAwQFBgcICQoL/8QAtRAAAgEDAwIEAwUFBAQAAAF9AQIDAAQRBRIhMUEGE1FhByJxFDKBkaEII0KxwRVS0fAkM2JyggkKFhcYGRolJicoKSo0NTY3ODk6Q0RFRkdISUpTVFVWV1hZWmNkZWZnaGlqc3R1dnd4eXqDhIWGh4iJipKTlJWWl5iZmqKjpKWmp6ipqrKztLW2t7i5usLDxMXGx8jJytLT1NXW19jZ2uHi4+Tl5ufo6erx8vP09fb3+Pn6/8QAHwEAAwEBAQEBAQEBAQAAAAAAAAECAwQFBgcICQoL/8QAtREAAgECBAQDBAcFBAQAAQJ3AAECAxEEBSExBhJBUQdhcRMiMoEIFEKRobHBCSMzUvAVYnLRChYkNOEl8RcYGRomJygpKjU2Nzg5OkNERUZHSElKU1RVVldYWVpjZGVmZ2hpanN0dXZ3eHl6goOEhYaHiImKkpOUlZaXmJmaoqOkpaanqKmqsrO0tba3uLm6wsPExcbHyMnK0tPU1dbX2Nna4uPk5ebn6Onq8vP09fb3+Pn6/9oADAMBAAIRAxEAPwD9UqKKgv7+20uxuL29uIrSzto2mmuJ3CRxIoyzMx4AABJJ4AFNJt2QE9Brwn4xfGK88N+FptQn1ZPBPnJLLo1pcXtlY3+qgGFFZ5NQTyLRQ8xZo2WSXZsOEcNCfNvC08Gp+JJtJ1rwjpnjGCPWBKNG8Qa5e6zqOlaO422t/NZ3ktxcwXRQkvCLZMrfW++WLypgv0lDJKtSh7ecrLW1rN6b7td0la6vdOzVjJ1EnY+v6K+FtE+KPibwb4ol0nxBo2v+HNXvYLOG4vPBXiH7fH4flljUJYzabczXljYtNdRRpbyP5UZgul+eIxTgfT/hT4h69pdxoGkePNLNpf6xEGttas7eOGxedl3izljFzO0FwBvXiSWF/LykxZxEqx2R1sGk1JSTV1Zq7VrtqzaaXrzW15bahGopdD0qijtRn2NfNmoZrxv47+NLTRftDX2oWmlWHhzT/wC3mudUMgs3v2Z49OjmWPLyxiWOaVkRdwaCFgRjB9k7V4f45vNV0PxN4o1Cx1nUtMvBqmjfari002O68rR9pBT98yRxx+abx3uPnMYLEghAF9nKoRliLy6L03aW6Tto3Z2ettCZK6ML4EaZD8QtUn8R6fPqelaK0kepTWskFnb3Lz3E0t/FbtNA8koQpdwXUqea6StcxqnkRi4tW9g1vx34O+GNiLC+1Cx0G006wM62kce1Le1iilcbUQYVRHbTFVA5EL7Qdpx5tefGvS/gfpL6Vq1lPqUdjJqdxcjQ1SZdJthNI+mwTAbVg86ExRQhyq5QKGIBYeQfEz4yfCX4h+MfED+Lfh5q1w0AsdCsvE+nX8MckqXVtcskZl8+NIUKT3ZOXaNlG6QqVRR9C8BiMzxEqlSnL2XTl5e6V9Wr3bvfWVmuhF1BWPqLS9d8H/GbSb02FwNUh065ks5J4xNa3NhdNbYkEcmElgnWK5KMyFXjLuhKurKPnzxfaeLfhz8TYNCiP/CRaL4k1HT4dVeSMvJIZbwlb5j5sUqXphWZVe2Z1t00eJhBHHLCtriaR+1n8Lv2dvCWqp4e+GPirQtFvdavUt1a2SCK5vYo4xOXjll8y1VW8pCpjAXcMLlZFTQ+LPxbtviDFNc6v4bj0OyttM1OCz0/xfY3NxDf3EV/oBgWe2gAkKtczi3ZV8xVZW3CRdyHvwOW4vCYpQ9lL2E9I81m7rW6Sd+ZPpFrW19rGc5K13ufSXws1nUdS8KLZa7eQ33iPRp5NK1OeNkDzSxHCXEkaACFriEw3Iix8i3CgFhhj19ePfAbxLqOqap4xj123MOt3t/a3kwtLG5jtVcaLpPnLulQGI+ZKQsU2yUqD8nyMR7Dj2r4jMKLo4mSta9nptqk7LyTdl6G0HeIV5H8c/CQ1+CWzlTOn+I7CTQ55CrskF4G83TrhyiEoiS+au7IG6aMENxt9cxWd4itLC/8P6nbaqyrpc1rLHds8hjAhKEOSwIKjbnnIxWODrvDV41F0/r709V5pFWvoeKeHPG0/gq7fw+rSeINVSzM01u2oRXd7cNCTbpdTtbwiZgZIGgkPlO5SOFtm5blE9Ut9d0rwr4NsPs+oy6+sOmLJZn7WlxeamiKiqyOzASvIzxDdkBnlXkbhXjnxQ8KQaLqwu003Xrm31BYtPOpeF5iNcQC9tg11LGsImmjgVIl8xWlJSNd6yBww5fW/GngvV/CHiHxN4T8baKni25n+0OPEOrf2XLqLRNmOPcj2zCBYmmWNHRVL4kyrmSaT6iWDp4xQqRTSb1stL9L6+7189Nv5duWK3eh9D+IfGsdpon9oWN7ZI8EhWa2uFaYyON6C2BhLFZDKvlgqsp3IyBGYgV84fD7xDq3xH8V+Im13V7jRvCt9bya3a6jpXiu7s7ywh+eWGWS2uJPkEAeSK48tpbbzngi8s+RMIe5+F/xA+HemeEfDsmqSaMPG2oxPZS2Oi6g+v6hKxMlxJGJY2mneNtjyspZlGSCzdToeAfgVNb3ugXU9zqWkeH9Lk+1HRL9oJb7VLlWZoJb+eLKFIneSVIoz80rfaJXeV3FOh7DL4Vo1E4vaLa3tfa17u60d2rtX01OaT5rcp2vwW0Q6d4PfUns5NNl126fVBYy2/2Z7S3ZVjtLdodq+S8VpFbRPHj5Xjbljlj31JRivka9Z16sqsuv4dl8loWlZWCue8e6bDrfhqfS7iO2kt7+SK1l+18IEaRQxB2kCQLkpkYMmwd66AUveopzdOamt07lLQ5Lw5qX/CSaStxp0ypcSpHDNewxK0VviNC0cD4xKAXbDAuivvBJKmOte+8M6frenzabq+n6dqelF1MNlPZq8SIqrgMrFlYhgxBAXAIGOMnRgt4rZGSGNIkLM5VFCgszFmPHckkk9ySal71tUqONRunpZ/P7/wCvzG3cq6bpNjo1sLfT7O3sYOMRW0SxrwAo4AA4CgfQD0q1R3o9K5m3J3ZIUtIaQ9aQH//Z" width="59" height="58">
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
        $filename = "voucher-download";
        return $dompdf->stream($filename . ".pdf");
    }
}
