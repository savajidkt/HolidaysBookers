<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BookingHistoryController extends Controller
{

    public function index($status = "all")
    {
        $pagename = "booking-history";
        return view('customer.booking-history.index',['pagename' => $pagename]);
    }
}
