<?php

namespace App\Http\Controllers\Corporate;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function dashboard()
    {
        return view('corporate.dashboard.index');
    }
}
