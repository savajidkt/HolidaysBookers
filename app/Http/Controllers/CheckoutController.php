<?php

namespace App\Http\Controllers;


use App\Models\City;
use App\Models\User;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Checkout;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;

use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;
use App\Libraries\Safeencryption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CheckoutRepository;
use App\Repositories\HotelListingRepository;
use App\Http\Requests\Checkout\CreateRequest;
use App\Repositories\HotelRoomListingRepository;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $hotelListingRepository;
    protected $hotelRoomListingRepository;
    protected $checkoutRepository;
    public function __construct(HotelListingRepository $hotelListingRepository, HotelRoomListingRepository $hotelRoomListingRepository, CheckoutRepository $checkoutRepository)
    {
        $this->hotelListingRepository       = $hotelListingRepository;
        $this->hotelRoomListingRepository       = $hotelRoomListingRepository;
        $this->checkoutRepository       = $checkoutRepository;
    }

    public function checkout($id)
    {
        try {

            $SafeencryptionObj = new Safeencryption;
            $requiredParamID = unserialize($SafeencryptionObj->decode($id));
           
            $requiredParamArr = Checkout::find($requiredParamID);
            
            if ($requiredParamArr) {
                $hotelsDetails = $this->hotelListingRepository->hotelDetails($requiredParamArr->hotel_id);

                //$offlineRoom = OfflineRoom::find($requiredParamArr->room_id);
                $offlineRoom = OfflineRoom::find(2);
                // dd($requiredParamArr->registration_number);

                return view('checkout.checkout', ['hotelsDetails' => $hotelsDetails, 'offlineRoom' => $offlineRoom, 'requiredParamArr' => $requiredParamArr, 'bookingKey' => $id]);
            }
        } catch (\Throwable $th) {
            return redirect()->route('home')->with('error', 'Internal problem');
        }
    }

    public function postLogin(Request $request)
    {
       
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            $SafeencryptionObj = new Safeencryption;
            $bookingID = unserialize($SafeencryptionObj->decode($request->redirect));
            $checkout = Checkout::find($bookingID);
            $checkout->update(array('user_id' => auth()->user()->id));            
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

    public function postRegistration(Request $request)
    {
        //dd($request->all()); 
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $data = $request->all();
        $check = $this->create($data);
        return redirect()->back()->with('success', '');
    }

    public function create(array $data)
    {

        $user = User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
        if ($user->id) {
            $SafeencryptionObj = new Safeencryption;
            $bookingID = unserialize($SafeencryptionObj->decode($data['bookingKey']));
            $checkout = Checkout::find($bookingID);
            $checkout->update(array('user_id' => $user->id));
            Auth::login($user);
        }
        return true;
    }

    public function store(CreateRequest $request)
    {
        dd($request->all());

        // $SafeencryptionObj = new Safeencryption;
        // $requiredParamID = unserialize($SafeencryptionObj->decode($request->bookingKey));            
        // $requiredParamArr = Checkout::find($requiredParamID)->toArray(); 

        // $requiredParamArr['firstname'] = $request->firstname;
        // $requiredParamArr['last_name'] = $request->lastname;
        // $requiredParamArr['email'] = $request->email;
        // $requiredParamArr['gst_enable'] = $request->gst_enable;
        // $requiredParamArr['registration_number'] = $request->registration_number;
        // $requiredParamArr['registered_company_name'] = $request->registered_company_name;
        // $requiredParamArr['registered_company_address'] = $request->registered_company_address;       
        // $data = $this->checkoutRepository->update($requiredParamArr, $checkout);

        // return redirect()->route('checkout.show', $data)->with('success', 'Your booking created successfully!');
    }



    public function update(Request $request,  Checkout $checkout)
    {

        $SafeencryptionObj = new Safeencryption;
        $requiredParamID = unserialize($SafeencryptionObj->decode($request->bookingKey));
        $requiredParamArr = Checkout::find($requiredParamID)->toArray();

        $requiredParamArr['gst_enable'] = $request->gst_enable;
        $requiredParamArr['registration_number'] = $request->registration_number;
        $requiredParamArr['registered_company_name'] = $request->registered_company_name;
        $requiredParamArr['registered_company_address'] = $request->registered_company_address;
        $requiredParamArr['payment_method'] = $request->payment_method;
        $requiredParamArr['passenger'] = passengerArr($request->all(), true);

        $data = $this->checkoutRepository->update($requiredParamArr, $checkout);

        // Add Payment Gatways Call here

        if ($request->payment_method == 1) {
            //Pay On time limit
            // $this->payOnTimeLimit($data);
        } else if ($request->payment_method == 2) {
            //Pay using wallet
            //$this->payUsingWallet($data);
        } else if ($request->payment_method == 3) {
            //Pay On Online payment
            //$this->payOnOnline($data);
        }

        // insert Data in Order table here
        return redirect()->route('checkout.show', $data)->with('success', 'Your booking created successfully!');
    }

    public function payOnTimeLimit($data)
    {
        $checkout = Checkout::find($data->id);
    }
    public function payUsingWallet($data)
    {
        $checkout = Checkout::find($data->id);
    }
    public function payOnOnline($data)
    {
        $checkout = Checkout::find($data->id);
    }

    public function ajaxTempStore(Request $request)
    {
        $checkoutRepositoryBack = "";
        $SafeencryptionObj = new Safeencryption;
        $requiredParamArr = unserialize($SafeencryptionObj->decode($request->extra));

        if (is_array($requiredParamArr) && count($requiredParamArr) > 0 && $requiredParamArr['hotel_id'] > 0) {
            $hotelsDetails = $this->hotelListingRepository->hotelDetails($requiredParamArr['hotel_id']);
            //$offlineRoom = OfflineRoom::find($requiredParamArr['room_id']);           
            $Tempdata['tax_amount'] = 10;
            $Tempdata['total_amount'] = 110;
            $Tempdata['bookingKey'] = $request->extra;

            $checkoutRepositoryBack = $this->checkoutRepository->createBooking($Tempdata);
            if (isset($checkoutRepositoryBack->id) > 0) {
                return response()->json([
                    'status' => true,
                    'redirectURL' => route('review-your-booking', selectRoomBooking($checkoutRepositoryBack->id, true)),
                    'message' => ''
                ]);
            }
        }
        return response()->json([
            'status' => false,
            'message' => ''
        ]);
    }

    public function show($id)
    {
        return view('checkout.thank-you');
    }
}
