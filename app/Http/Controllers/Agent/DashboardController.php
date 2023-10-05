<?php

namespace App\Http\Controllers\Agent;

use App\Models\Order;

// use App\Exports\ReportsExport;
// use App\Http\Requests\User\DemofromCreateRequest;
// use App\Http\Requests\User\PasswordRequest;
// use App\Models\User;
// use App\Repositories\UserRepository;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Hash;
// use App\Exports\StudentExport;
// use Maatwebsite\Excel\Facades\Excel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function dashboard()
    {
        $pagename = "dashboard";
        return view('agent.dashboard.index', ['pagename' => $pagename]);
    }
    public function getBookingList(Request $request)
    {
        $user = auth()->user();

        $bookingData = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('payment_status', 1)->get();
        $bookingArr = [];
        $bookingDataArr = [];
        if (count($bookingData)) {
            foreach ($bookingData as $key => $value) {
                $bookingDataArrTemp = [];
                $bookingDataArr[] = $this->getBookedHotel($value);
                //dd($bookingDataArr);
                // if ($value->check_in_date != "0000-00-00") {
                //     $bookingDataArrTemp = [];
                //     $bookingDataArrTemp['title'] = $value->hotel_name;
                //     $bookingDataArrTemp['start'] = $value->check_in_date;
                //     $bookingDataArrTemp['end'] = $value->check_out_date;
                //     $bookingDataArr[] = $bookingDataArrTemp;
                // }
                //$bookingDataArr[] = $bookingDataArrTemp;
            }
            if (count($bookingDataArr) > 0) {
                foreach ($bookingDataArr as $key => $value) {
                    if (count($value) > 0) {
                        foreach ($value as $sub_key => $sub_value) {
                            $bookingArr[] = $sub_value;
                        }
                    }
                }
            }
        }       
       
        return response()->json([
            'status' => true,
            'booking' => $bookingArr,
            'message' => ''
        ]);
    }

    public function getBookedHotel($order)
    {
        $returnArr = [];
        if (count($order->order_hotel)) {
            foreach ($order->order_hotel as $key => $value) {
                $returnArr[] = $this->getBookedHotelRoom($value);
            }
        }
        return $returnArr;
    }

    public function getBookedHotelRoom($hotel)
    {
        $returnArr = [];
        if (count($hotel->order_hotel_room)) {
            foreach ($hotel->order_hotel_room as $key => $value) {                
                $returnTempArr = [];
                $returnTempArr['title'] = $hotel->hotel_name . ' - ' . $value->room_name . ' ( Adult ' . $value->adult . ' - Child ' . $value->child . ')';
                $returnTempArr['start'] = $value->check_in_date;
                $returnTempArr['end'] = $value->check_out_date;
                $returnTempArr['url'] =  route('agent.view-booking-history', $value->order_id);
                $returnArr = $returnTempArr;
            }
        }
        return $returnArr;
    }
}
