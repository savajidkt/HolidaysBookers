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
<<<<<<< HEAD
=======
use App\Models\DraftOrderHotelRoom;
>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
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

<<<<<<< HEAD
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
=======
        $user = auth()->user();
        $DraftOrder = DraftOrder::where('agent_code', $user->agents->agent_code)->paginate(10);
        return view('agent.draft-history.index', ['user' => $user, 'pagename' => $pagename, 'draftOrder' => $DraftOrder]);
        
>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
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
<<<<<<< HEAD
=======

    public function draftDeleteOrder($order_id)
    {

        $user = auth()->user();
        $DraftOrder = DraftOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        if ($DraftOrder) {
            DraftOrder::where('id', $DraftOrder->id)->delete();
            return redirect()->back()->with('success', 'Deleted successfully!');
        }
        return redirect()->back()->with('error', 'Deleted failed!');
    }

    public function draftDeleteRoom($order_id)
    {

        $user = auth()->user();
        $DraftOrder = DraftOrder::where('agent_code', $user->agents->agent_code)->where('id', $order_id)->first();
        if ($DraftOrder && isset($_GET['orde_room_id']) && $_GET['orde_room_id'] > 0) {
            $DraftOrderHotelRoom = DraftOrderHotelRoom::where('draft_id', $order_id)->where('id', $_GET['orde_room_id'])->first();
            if ($DraftOrderHotelRoom) {
                DraftOrderHotelRoom::where('id', $DraftOrderHotelRoom->id)->delete();
                return redirect()->back()->with('success', 'Deleted successfully!');
            }
        }
        return redirect()->back()->with('error', 'Deleted failed!');
    }

    public function view(Request $request)
    {
        $pagename = "Draft View";
        $user = auth()->user();
        $DraftOrder = DraftOrder::where('agent_code', $user->agents->agent_code)->where('id', $request->id)->first();
        if ($DraftOrder) {
            $HotelListingRepository = new HotelListingRepository();
            return view('agent.draft-history.view', ['order_id' => $request->id, 'pagename' => $pagename, 'draftOrder' => $DraftOrder, 'hotelListingRepository' => $HotelListingRepository]);
        } else {
            return redirect()->back()->with('error', 'Access Denied');
        }
    }

>>>>>>> eaf5c587bdde40833701dc134f9d3daa0a00a061
}
