<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;

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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{

    public function dashboard()
    {
        return view('agent.dashboard.index');
    }   
}
