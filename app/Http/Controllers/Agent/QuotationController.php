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

        $pagename = "Quote Download";
        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();

        if ($QuoteOrder) {
            $HotelListingRepository = new HotelListingRepository();

            $fileNamePDF = "Quote-" . $user->agents->agent_code . "-" . date('Y-m-d-h-i-s') . ".pdf";
            $myContent = view('agent.quotation.download', ['fileNamePDF' => $fileNamePDF, 'order_id' => $order_id, 'pagename' => $pagename, 'quoteData' => $QuoteOrder, 'hotelListingRepository' => $HotelListingRepository]);

            if ($myContent != "") {
                try {
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->set('defaultFont', 'calibri');
                    $options->setIsFontSubsettingEnabled(true);
                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($myContent);
                    $dompdf->setPaper('Legal', 'portrait');
                    $dompdf->render();
                    $dompdf->stream($fileNamePDF, array("Attachment" => false));
                    exit;
                } catch (Exception $e) {
                    print_r($e->getMesssage());
                    exit;
                }
            }
        } else {
            return redirect()->back()->with('error', 'Access Denied');
        }
    }

    public function sendEmailPdf($order_id)
    {
        $pagename = "Quote Send";
        $user = auth()->user();
        $QuoteOrder = QuoteOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();

        if ($QuoteOrder) {
            $HotelListingRepository = new HotelListingRepository();

            $fileNamePDF = "Quote-" . $user->agents->agent_code . "-" . date('Y-m-d-h-i-s') . ".pdf";
            $myContent = view('agent.quotation.download', ['fileNamePDF' => $fileNamePDF, 'order_id' => $order_id, 'pagename' => $pagename, 'quoteData' => $QuoteOrder, 'hotelListingRepository' => $HotelListingRepository]);

            if ($myContent != "") {
                try {
                    $options = new Options();
                    $options->set('isRemoteEnabled', true);
                    $options->set('defaultFont', 'calibri');
                    $options->setIsFontSubsettingEnabled(true);
                    $dompdf = new Dompdf($options);
                    $dompdf->loadHtml($myContent);
                    $dompdf->setPaper('Legal', 'portrait');
                    $dompdf->render();
                    $output = $dompdf->output();
                    $filePath = storage_path('app/quote_pdf/' . $fileNamePDF);
                    file_put_contents($filePath, $output);
                    $this->sendEmailWithQuote($filePath);
                    return redirect()->back()->with('success', 'Mail sent successfully.');
                    exit;
                } catch (Exception $e) {
                    print_r($e->getMesssage());
                    exit;
                }
            }
        } else {
            return redirect()->back()->with('error', 'Access Denied');
        }
    }

    public function sendEmailWithQuote($filePath)
    {

        $senderemail = "";
        $subject = "";
        $reviews = "";
        $emailsArr = [];
        try {
            if (isset($_POST['emails'])) {
                $senderemail = $_POST['senderemail'];
                $subject = $_POST['subject'];
                $reviews = $_POST['reviews'];
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
        return true; //redirect()->back()->with('success', 'Mail sent successfully.');
    }  
}
