<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Exports\ReportsExport;
use App\Exports\StudentExport;
use Illuminate\Support\Facades\DB;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\User\PasswordRequest;
use App\Http\Requests\User\DemofromCreateRequest;
use App\Models\Agent;
use App\Models\AgentMarkup;
use App\Models\WalletTransaction;

class UserController extends Controller
{
    //
    /** @var UserRepository $userRepository */
    protected $userRepository;

    /**
     * Constructor to initialize class
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository       = $userRepository;
    }
    /**
     * Method changePassword
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function changePassword(PasswordRequest $request)
    {
        $user = auth()->user();
        $this->userRepository->changePassword($user, $request->except(['_token', '_method']));

        return redirect()->route('demographic')->with('success', 'Your password changed successfully!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function demoGraphicSave(DemofromCreateRequest $request)
    {

        $this->userRepository->demoformcreate($request->all());

        return redirect()->route('home')->with('success', "User update successfully!");
    }


    public function unSubscribe()
    {
        return view('unsubscribe');
    }
    public function reportExcelExport($id)
    {

        return Excel::download(new ReportsExport($id), 'survey-reports-' . $id . '.xlsx');
    }

    public function userPostLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return response()->json([
                'status' => true,
                'message' => 'You have Successfully loggedin'
            ]);
        }
        return response()->json([
            'status' => false,
            'message' => 'Oppes! You have entered invalid credentials'
        ]);
    }

    public function userPostRegistration(Request $request)
    {

        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:6|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:6'
        ];

        $validation = Validator::make($request->all(), $rules);
        if ($validation->fails()) {
            $returnArr = [];
            $returnArr['status'] = false;
            $returnArr['message'] = '';
            $returnArr['validation'] = true;
            $validationArr = $validation->errors()->toArray();
            foreach ($validationArr as $key => $value) {
                $returnArr[$key] = $value[0];
            }
            return response()->json($returnArr);
        }

        $data = $request->all();
        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'user_type' => 1,
            'password' => Hash::make($data['password'])
        ]);
        if ($user->id) {        
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

            Auth::login($user);

            return response()->json([
                'status' => true,
                'validation' => false,
                'message' => 'You have Create Account Successfully'
            ]);
        }
        return response()->json([
            'status' => false,
            'validation' => false,
            'message' => 'Oppes! Create account failed.'
        ]);
    }
}
