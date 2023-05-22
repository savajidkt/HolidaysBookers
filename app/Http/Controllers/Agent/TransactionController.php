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

class TransactionController extends Controller
{

    // protected $userRepository;
    // public function __construct(UserRepository $userRepository)
    // {
    //     $this->userRepository       = $userRepository;
    // }

    public function index($status = "all")
    {        
        $pagename = "transaction";
        $user = auth()->user();            
        return view('agent.transaction.index', ['pagename' => $pagename, 'user' => $user, 'status' =>$status]);
    }    
}
