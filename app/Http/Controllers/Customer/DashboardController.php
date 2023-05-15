<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function dashboard()
    {        
        $pagename = "dashboard";
        return view('customer.dashboard.index',['pagename' => $pagename]);
    }
}
