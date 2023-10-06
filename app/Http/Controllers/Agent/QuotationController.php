<?php

namespace App\Http\Controllers\Agent;

use App\Models\User;
use App\Models\Country;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\QuoteMail;
use App\Models\QuoteOrder;
use App\Models\QuoteOrderHotelRoom;
use App\Repositories\HotelListingRepository;
use App\Repositories\UserRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use PDF;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class QuotationController extends Controller
{

    public function index(Request $request)
    {
        $pagename = "quotation";
        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->paginate(10);
        return view('agent.quotation.index', ['user' => $user, 'pagename' => $pagename, 'quoteData' => $QuoteOrder]);
    }

    public function editPrice(Request $request)
    {
        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $request->order_id)->first();
        if ($QuoteOrder && isset($request->room_id) && $request->room_id > 0) {
            $QuoteOrderRoom = QuoteOrderHotelRoom::where('quote_id', $request->order_id)->where('id', $request->room_id)->first();
            if ($QuoteOrderRoom) {

                QuoteOrderHotelRoom::where('id', $QuoteOrderRoom->id)->update(['extra_markup_price' => $request->extra_markup_price]);
                return redirect()->back()->with('success', 'Update price successfully!');
            }
        }
        return redirect()->back()->with('error', 'Update price failed!');
    }

    public function deleteOrder($order_id)
    {

        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        if ($QuoteOrder) {
            QuoteOrder::where('id', $QuoteOrder->id)->delete();
            return redirect()->back()->with('success', 'Deleted successfully!');
        }
        return redirect()->back()->with('error', 'Deleted failed!');
    }

    public function deleteRoom($order_id)
    {

        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        if ($QuoteOrder && isset($_GET['orde_room_id']) && $_GET['orde_room_id'] > 0) {
            $QuoteOrderRoom = QuoteOrderHotelRoom::where('quote_id', $order_id)->where('id', $_GET['orde_room_id'])->first();
            if ($QuoteOrderRoom) {
                QuoteOrderHotelRoom::where('id', $QuoteOrderRoom->id)->delete();
                return redirect()->back()->with('success', 'Deleted successfully!');
            }
        }
        return redirect()->back()->with('error', 'Deleted failed!');
    }

    public function view(Request $request)
    {
        $pagename = "Quote View";
        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $request->id)->first();
        if ($QuoteOrder) {
            $HotelListingRepository = new HotelListingRepository();
            return view('agent.quotation.view', ['order_id' => $request->id, 'pagename' => $pagename, 'quoteData' => $QuoteOrder, 'hotelListingRepository' => $HotelListingRepository]);
        } else {
            return redirect()->back()->with('error', 'Access Denied');
        }
    }

   

    public function downloadPdf($order_id)
    {

        $user = auth()->user();

        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        $logo = url('storage/app/upload/' . $user->agents->user_id . '/' . $user->agents->agent_company_logo);
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
									<img src="' . $logo . '" style="width: 100px;" />
								</td>
								<td>
                                (w)' . $user->agents->agent_website . '<br />
                                (e)' . $user->agents->agent_email . '
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
                                <strong>' . $user->agents->agent_company_name . '</strong><br />
                                ' . $user->agents->agent_office_address . '<br />                                
                                City: ' . $user->agents->city->name . ', State: ' . $user->agents->state->name . ', Country: ' . $user->agents->country->name . '-' . $user->agents->agent_pincode . '<br />
                                (P) ' . $user->agents->agent_mobile_number . '<br />
                                (PAN) ' . $user->agents->agent_pan_number . ' (GST) ' . $user->agents->agent_gst_number . '
								</td>								
							</tr>
						</table>
					</td>
				</tr>		
			</table>
            <hr class="my-2">
            
            ' . $this->orderTableCreatePDF($QuoteOrder) . '

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
                                <strong>for ' . $user->agents->agent_company_name . '</strong><br />
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
                                (Prepared by: ' . $user->agents->agent_company_name . ')                              
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
        $filename = "quotation-" . $user->agents->agent_code . "-download";
        return $dompdf->stream($filename . ".pdf");
    }

    public function orderTableCreatePDF($quoteData)
    {


        $tableStr = '';
        $subTotal = 0;
        $total = 0;
        $tax = 0;
        $discount = 0;
        $serviceSectionAMT = 0;

        $tableStr .= '<table cellpadding="0" cellspacing="0">';
        $tableStr .= '<tr class="heading">';
        $tableStr .= '<td>HOTEL</td>';

        $tableStr .= '<td class="text-center">ADULT</td>';
        $tableStr .= '<td class="text-center">CHILD</td>';
        $tableStr .= '<td class="text-center">CHACK-IN</td>';
        $tableStr .= '<td class="text-center">CHACK-OUT</td>';
        $tableStr .= '<td class="text-right">TOTAL</td>';
        $tableStr .= '</tr>';

        if ($quoteData) {
            $hotelListingRepository = new HotelListingRepository();
            if (count($quoteData->quote_hotel_rooms) > 0) {
                foreach ($quoteData->quote_hotel_rooms as $key => $value) {
                    $hotelsDetails = $hotelListingRepository->hotelDetailsArr($value->hotel_id);

                    if (count($hotelsDetails) > 0 && count($hotelsDetails['hotel']) > 0) {
                        $hotelsDetails = $hotelsDetails['hotel'];
                        $serviceSectionAMT = $serviceSectionAMT + $value['price'] + $value['extra_markup_price'];
                        $tableStr .= '<tr>';
                        $tableStr .= '<td class="py-1 pl-4">' . $hotelsDetails['hotel_name'] . '<br>' . $value->room_name . '</td>';
                        $tableStr .= '<td class="py-1">' . $value->adult . '</td>';
                        $tableStr .= '<td class="py-1">' .  $value->child . '</td>';
                        $tableStr .= '<td class="py-1">' . $value->check_in_date . '</td>';
                        $tableStr .= '<td class="py-1">' . $value->check_out_date . '</td>';
                        $tableStr .= '<td class="py-1">' . $value->price + $value->extra_markup_price . '</td>';
                        $tableStr .= '</tr>';
                        $subTotal = $subTotal + ($value->price + $value->extra_markup_price);
                    }
                }
            }
        }

        $tableStr .= '<tr class="total">';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td class="text-right">Subtotal: <strong>' . numberFormat($subTotal, $quoteData->booking_currency) . '</strong></td>';
        $tableStr .= '</tr>';

        $tableStr .= '<tr class="total">';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td class="text-right">Discount: <strong>' . numberFormat($discount, $quoteData->booking_currency) . '</strong></td>';
        $tableStr .= '</tr>';

        $tableStr .= '<tr class="total">';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td class="text-right">Tax:<strong> ' . numberFormat($tax, $quoteData->booking_currency) . '</strong></td>';
        $tableStr .= '</tr>';

        $total = ($subTotal + $tax) - $discount;

        $tableStr .= '<tr class="total">';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td></td>';
        $tableStr .= '<td class="text-right">Total:<strong>' . numberFormat($total, $quoteData->booking_currency) . '</strong></td>';
        $tableStr .= '</tr>';
        $tableStr .= '</table>';



        return $tableStr;
    }  

    public function sendEmailPdf($order_id)
    {

        $user = auth()->user();

        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        $logo = url('storage/app/upload/' . $user->agents->user_id . '/' . $user->agents->agent_company_logo);
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
									<img src="' . $logo . '" style="width: 100px;" />
								</td>
								<td>
                                (w)' . $user->agents->agent_website . '<br />
                                (e)' . $user->agents->agent_email . '
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
                                <strong>' . $user->agents->agent_company_name . '</strong><br />
                                ' . $user->agents->agent_office_address . '<br />                                
                                City: ' . $user->agents->city->name . ', State: ' . $user->agents->state->name . ', Country: ' . $user->agents->country->name . '-' . $user->agents->agent_pincode . '<br />
                                (P) ' . $user->agents->agent_mobile_number . '<br />
                                (PAN) ' . $user->agents->agent_pan_number . ' (GST) ' . $user->agents->agent_gst_number . '
								</td>								
							</tr>
						</table>
					</td>
				</tr>		
			</table>
            <hr class="my-2">
            
            ' . $this->orderTableCreatePDF($QuoteOrder) . '

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
                                <strong>for ' . $user->agents->agent_company_name . '</strong><br />
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
                                (Prepared by: ' . $user->agents->agent_company_name . ')                              
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
        $filename = "quotation-" . $user->agents->agent_code . "-download-" . date('Y-m-d-h-i-s') . ".pdf";

        $output = $dompdf->output();
        $filePath = storage_path('app/quote_pdf/' . $filename);
        file_put_contents($filePath, $output);
        $this->sendEmailWithQuote($filePath);
        return redirect()->back()->with('success', 'Mail sent successfully.');
    }

    public function sendEmailWithQuote($filePath)
    {

        $senderemail = "";
        $subject = "";
        $reviews = "";
        $emailsArr = [];
        try {
            if (isset($_POST['emails'])) {
                $senderemail = isset($_POST['senderemail']) ? $_POST['senderemail'] : '';
                $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
                $reviews = isset($_POST['reviews']) ? $_POST['reviews'] : '';
                $emailsArr = explode(',', $_POST['emails']);
            }

            if (count($emailsArr) >  0) {
                foreach ($emailsArr as $key => $value) {
                    $paramArr = [
                        'fileName' => $filePath,
                        'subject' => $subject,
                        'reviews' => $reviews,
                        'senderemail' => $senderemail,
                    ];
                    Mail::to(trim($value))->send(new QuoteMail($paramArr));
                }
            }
        } catch (\Exception $e) {           
            return $e->getMessage();
        }
        return true;
    }
}
