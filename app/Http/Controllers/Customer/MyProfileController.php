<?php

namespace App\Http\Controllers\Customer;

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

class MyProfileController extends Controller
{

    protected $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository       = $userRepository;
    }

    public function editProfile()
    {        
        $pagename = "my-profile";
        $user = auth()->user();            
        return view('customer.my-profile.index', ['pagename' => $pagename, 'user' => $user]);
    }

    public function updateProfile(Request $request)
    {
        
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone_number' => 'required',
        ]);
        $user = auth()->user();            
        $this->userRepository->updateCustomer($request->all(), $user);

        return redirect()->route('customer.my-profile')->with('success', 'Profile updated successfully!');
    }

    public function editLocation()
    {
        $pagename = "my-profile";
        $user = auth()->user();
        $countries    =  Country::where('status', Country::ACTIVE)->get();
        return view('customer.my-profile.location', ['pagename' => $pagename, 'user' => $user ,'countries' => $countries]);
    }

    public function updateLocation(Request $request)
    {
        // $request->validate([
        //     'country_id' => 'required'
        // ]);
        $user = auth()->user();            
        $this->userRepository->updateCustomerLocation($request->all(), $user);
        return redirect()->route('customer.my-location')->with('success', 'Location updated successfully!');
    }

    public function editChangePassword()
    {
        $pagename = "change-password";
        return view('customer.my-profile.change-password', ['pagename' => $pagename]);
    }

    public function updateChangePassword(Request $request)
    {       
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required',
            'new_password_confirmation'  => ['required','same:new_password'],
        ]);

        $user = auth()->user();         
        $this->userRepository->changePassword($user, $request->all());
        return back()->with("success", "Password changed successfully!");        
    }
}
