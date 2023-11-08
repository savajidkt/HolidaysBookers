<?php

namespace App\Http\Controllers\Agent;

use Dompdf\Dompdf;
use Dompdf\Options;

use App\Models\Order;
use App\Models\Freebies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\DraftOrder;
use App\Models\OrderHotelRoom;
use App\Models\OrderHotelRoomPassenger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\HotelListingRepository;

class DraftHistoryController extends Controller
{

    public function index(Request $request)
    {
        $pagename = "draft-history";

        if ($request->ajax()) {
            $isDraft = false;
            $user = auth()->user();

            $data = DraftOrder::select('*')->where('agent_code', $user->agents->agent_code);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('created_at', function (DraftOrder $order) {
                    return dateFormat($order->created_at, 'd M, Y');
                })                
                ->editColumn('passenger_type', function (DraftOrder $order) {
                    return $order->guest_name;
                })
                ->addColumn('pax', function (DraftOrder $order) {
                    return 'Room : ' . $order->total_rooms . ' Adult : ' . $order->total_adult . '<br> Children : ' . $order->total_child . '<br> Night : ' . $order->total_nights;
                })
                ->editColumn('booking_amount', function (DraftOrder $order) {
                    return numberFormat($order->booking_amount, globalCurrency());
                })                
                ->addColumn('action', function (DraftOrder $order)  use ($isDraft) {
                    return '-';
                    //return getOrderHistoryAction($order->id, $order);
                })
                ->rawColumns(['action', 'pax'])->make(true);
        }
        return view('agent.draft-history.index', ['pagename' => $pagename]);
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
}
