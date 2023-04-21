<?php

namespace App\Http\Controllers\Admin\Orders;

use App\Models\Order;
use App\Models\Reach;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class OrdersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        if ($request->ajax()) {
            $data = Order::select('*');
            
            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('prn_no', function (Order $order) {
                    return $order->prn_no;
                })
                ->editColumn('hotel_id', function (Order $order) {
                    return $order->country->name;
                })
                ->editColumn('city_id', function (Order $order) {
                    return $order->city->name;
                })
                ->editColumn('created_at', function (Order $order) {
                    return $order->created_at;
                })
                ->editColumn('check_in_date', function (Order $order) {
                    return $order->check_in_date;
                })
                ->editColumn('check_out_date', function (Order $order) {
                    return $order->check_out_date;
                })
                ->editColumn('guest_lead', function (Order $order) {
                    return $order->guest_lead;
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
                ->editColumn('status', function (Order $order) {
                    return $order->status_name;
                })
                ->addColumn('action', function (Order $order) {
                    return $order->action;
                })
                ->rawColumns(['action', 'status', 'payment'])->make(true);
        }

        return view('admin.order.index', ['user' => $user]);
    }

    public function create()
    {
       // permissionCheck('reach-us-create');
       
        return view('admin.reach.create');
    }
}
