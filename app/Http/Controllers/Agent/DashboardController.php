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
        //dd($user->agents->agent_code);
        $bookingData = Order::select('*')->where('agent_code', $user->agents->agent_code)->where('payment', 1)->get();
        $bookingDataArr = [];
        if (count($bookingData)) {
            foreach ($bookingData as $key => $value) {
                if ($value->check_in_date != "0000-00-00") {
                    $bookingDataArrTemp = [];
                    $bookingDataArrTemp['title'] = $value->hotel_name;
                    $bookingDataArrTemp['start'] = $value->check_in_date;
                    $bookingDataArrTemp['end'] = $value->check_out_date;
                    $bookingDataArr[] = $bookingDataArrTemp;
                }
            }
        }       

        return response()->json([
            'status' => true,
            'booking' => $bookingDataArr,
            'message' => ''
        ]);
    }
}
