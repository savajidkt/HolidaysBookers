<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BookingHistoryController extends Controller
{

    public function index($status = "all")
    {        
        $pagename = "booking-history";
        return view('agent.booking-history.index',['pagename' => $pagename, 'status' =>$status]);
    }
}
