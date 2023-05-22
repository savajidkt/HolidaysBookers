<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TravelCalendarController extends Controller
{

    public function index()
    {        
        $pagename = "travel-calendar";
        return view('agent.travel-calendar.index',['pagename' => $pagename]);
    }
}
