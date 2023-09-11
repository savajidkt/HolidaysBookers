<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function firstTimePasswordChange()
    {
        $user = User::find(auth()->user()->id);
        
        if($user->is_first_time_login===0){
            return view('auth.passwords.first-time-password-change');
        }else{
            return redirect()->route('home');
        } 
    }
    
    public function showResetForm(Request $request, $token = null)
    {
        
        $updatePassword = DB::table('password_resets')
            ->where([
                'token' => $token
            ])
            ->first();
            
        if (!$updatePassword) {
            // return back()->withInput()->with('error', 'Invalid token!');
            return view('errors.404');
        }

        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
}
