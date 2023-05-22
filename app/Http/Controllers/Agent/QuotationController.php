<?php

namespace App\Http\Controllers\Agent;

use App\Models\User;
use App\Models\Country;
use App\Models\UserMeta;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{

    // protected $userRepository;
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->userRepository       = $userRepository;
    // }

    public function index()
    {        
        $pagename = "quotation";
        $user = auth()->user();            
        return view('agent.quotation.index', ['pagename' => $pagename, 'user' => $user]);
    }    
}
