<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class VerificationController extends Controller
{
    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository       = $userRepository;
    }

    public function index()
    {
        $pagename = "verification";
        $user = auth()->user();   
           
        return view('customer.verification.index', ['pagename' => $pagename, 'user' => $user]);
    }

    public function edit($id)
    {
        
        $pagename = "verification";
        $user = auth()->user();
        if( $user->usermeta->phone_status == 1 ){
            return redirect()->route('customer.verification')->with('error', 'You phone number already verified.');       
        }  
        return view('customer.verification.edit', ['pagename' => $pagename, 'user' => $user]);
    }

    public function update(Request $request)
    {        
        $user = auth()->user();            
        $this->userRepository->updateCustomerVarification($request->all(), $user);
        return redirect()->route('customer.verification')->with('success', 'Verification updated successfully!');       
    }
}
