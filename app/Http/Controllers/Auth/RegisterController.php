<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Agent;
use App\Models\AgentMarkup;
use App\Models\WalletTransaction;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'type' => ['required'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'same:password_confirmation'],
            'password_confirmation' => ['required', 'string', 'min:6'],
            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'user_type' => $data['type'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        $agent_code = createAgentCode($user->id);
        $agent = Agent::create([
            'user_id' => $user->id,
            'agent_code' => $agent_code,
        ]);
        WalletTransaction::create([
            'user_id' => $user->id,
            'agent_id' => $agent->id,
        ]);
        AgentMarkup::create([
            'code' => $agent_code
        ]);
        
        return $user;
    }
}
