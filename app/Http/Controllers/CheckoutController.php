<?php

namespace App\Http\Controllers;


use Session;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Amenity;
use App\Models\Country;

use App\Models\Checkout;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;
use App\Libraries\Safeencryption;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Repositories\CheckoutRepository;
use App\Repositories\HotelListingRepository;
use App\Http\Requests\Checkout\CreateRequest;
use App\Repositories\HotelRoomListingRepository;
use Redirect;

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

    public function index(Request $request)
    {

        $requiredParamArr = getBookingCart('bookingCart');
        if ($requiredParamArr) {
            return view('checkout.checkout', ['hotelListingRepository' => $this->hotelListingRepository, 'hotelsDetails' => [], 'offlineRoom' => [], 'requiredParamArr' => $requiredParamArr, 'bookingKey' => '', 'extraData' => [], 'user' => auth()->user()]);
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
    }

    public function store(Request $request)
    {
        if ($request->button_name == "Draft") {
            $res = $this->saveAsDraft($request);
            if ($res) {
                return redirect()->route('home')->with('success', 'Your booking draft created successfully!');
            } else {
                return redirect()->route('home')->with('error', 'Your booking draft created failed!');
            }
        } else {
            $SafeencryptionObj = new Safeencryption;
            if ($request->payment_method == 1) {
                //Pay On time limit
                // $this->payOnTimeLimit($data);
            } else if ($request->payment_method == 2) {
                //Pay using wallet
                if (availableBalance(auth()->user()->agents->id) > getFinalAmountChackOut()) {
                    $data = $this->checkoutRepository->createBooking($request->all());
                    $res = $this->payUsingWallet($data);
                    if ($res) {
                        $this->removeTempData($data);
                        return redirect()->route('checkout.show', [$SafeencryptionObj->encode($res->id)])->with('success', 'Your booking created successfully!');
                    } else {
                        return redirect()->back()->with('error', 'Insufficient Balance');
                    }
                } else {
                    return redirect()->back()->with('error', 'Insufficient Balance');
                }
            } else if ($request->payment_method == 3) {
                //Pay On Online payment            
                $dataObj = $this->checkoutRepository->createBooking($request->all());
                return view('checkout.rozarpay', ['requestData' => $request->all(), 'dataObj' => $dataObj]);
            }
        }
        //return redirect()->route('checkout.show', [])->with('error', 'Your booking created successfully!');

    }

    public function saveAsDraft($request)
    {
        // dd($request->all());
        $data = $this->checkoutRepository->createBooking($request->all());
        $res = $this->checkoutRepository->createOrderBooking($data);

        if ($res) {
            $this->removeTempData($data);
            return true;
        }
        return false;
    }


    public function update(Request $request,  Checkout $checkout)
    {
        $this->payUsingWallet($checkout);
        $SafeencryptionObj = new Safeencryption;
        $requiredParamID = unserialize($SafeencryptionObj->decode($request->bookingKey));
        $requiredParamArr = Checkout::find($requiredParamID)->toArray();
        $requiredParamArr['gst_enable'] = $request->gst_enable;
        $requiredParamArr['registration_number'] = $request->registration_number;
        $requiredParamArr['registered_company_name'] = $request->registered_company_name;
        $requiredParamArr['registered_company_address'] = $request->registered_company_address;
        $requiredParamArr['payment_method'] = $request->payment_method;
        $requiredParamArr['passenger'] = passengerArr($request->all(), true);

        //dd(unserialize($SafeencryptionObj->decode($requiredParamArr['bookingKey'])));
        $data = $this->checkoutRepository->update($requiredParamArr, $checkout);

        // Add Payment Gatways Call here
        dd($request->payment_method);
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
        // if ($this->PayForAgentWallet($data)) {
        return $this->checkoutRepository->createOrderBooking($data);
        //  }
        return false;
    }
    public function payOnOnline(Request $request)
    {

        $SafeencryptionObj = new Safeencryption;
        $input = $request->all();
        $api = new Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
        $payment = $api->payment->fetch($input['razorpay_payment_id']);

        $hotelListingRepository = new HotelListingRepository;
        $data = Checkout::where('unique_number', $input['temp_order_id'])->first();
        $extra_data = unserialize($data->extra_data);
        $hotelsDetails = $this->hotelListingRepository->hotelDetailsArr(getHotelID($extra_data));


        //$input['temp_order_id']
        if (count($input)  && !empty($input['razorpay_payment_id']) && !empty($input['temp_order_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                if ($response) {
                    $res = $this->checkoutRepository->createOrderBooking($data, $response);
                    if ($res) {
                        $this->removeTempData($data);
                        return redirect()->route('checkout.show', [$SafeencryptionObj->encode($res->id)])->with('success', 'Your booking created successfully!');
                    }
                }
            } catch (\Exception $e) {

                return redirect()->route('review-your-booking', [$SafeencryptionObj->encode($hotelsDetails['hotel']['id'])])->with('error', $e->getMessage());
            }
        }

        return redirect()->route('review-your-booking', [$SafeencryptionObj->encode($hotelsDetails['hotel']['id'])])->with('error', 'internal server error');
    }

    public function payOnOnlineSuccess(Request $request)
    {
        dd('Succ');
        return view('checkout.rozarpaySuccess');
    }
    public function payOnOnlineFailed(Request $request)
    {
        dd('Faild');
        return view('checkout.rozarpayFailed');
    }

    public function PayForAgentWallet($data)
    {
        $extra_data = unserialize($data->extra_data);
        $paybleAmount = getOriginAmountChackOut($extra_data);
        $user = User::find($data->user_id);
        if (availableBalance($user->agents->id) > $paybleAmount) {
            $balance = calculateBalance($user->agents->id, '0', $paybleAmount);
            if ($balance) {
                $extra_data = unserialize($data->extra_data);
                $dataDebit = [
                    'user_id'        => $data->user_id,
                    'agent_id'        => $user->agents->id,
                    'transaction_type'        => 'Debit',
                    'pnr'        => '',
                    'amount'     => numberFormat(getOriginAmountChackOut($extra_data)),
                    'type'     => 0,
                    'comment'     => 'Booking Hotel',
                    'balance'     => numberFormat($balance),
                ];
                return $this->checkoutRepository->updateCredit($dataDebit);
            }
        }
        return false;
    }


    public function ajaxTempStore(Request $request)
    {
        $SafeencryptionObj = new Safeencryption;
        $requiredParamArr = unserialize($SafeencryptionObj->decode($request->extra));
        $cart = [];
        if (is_array(getBookingCart('bookingCart')) && count(getBookingCart('bookingCart')) > 0) {
            $bookingCart = getBookingCart('bookingCart');
            $bookingCart[] = $requiredParamArr;
            setBookingCart('bookingCart', $bookingCart);
        } else {
            $cart[] = $requiredParamArr;
            setBookingCart('bookingCart', $cart);
        }
        return response()->json([
            'status' => true,
            'redirectURL' => route('cart'),
            'message' => ''
        ]);
    }


    public function ajaxTempRemove(Request $request)
    {
        $SafeencryptionObj = new Safeencryption;
        $requiredParamArr = unserialize($SafeencryptionObj->decode($request->extra));
        $bookingCartArr = getBookingCart('bookingCart');

        if (is_array($bookingCartArr) && count($bookingCartArr)) {
            foreach ($bookingCartArr as $key => $value) {
                if ($value['hotel_id'] == $requiredParamArr['hotel_id'] && $value['room_id'] == $requiredParamArr['room_id']) {
                    unset($bookingCartArr[$key]);
                }
            }
        }
        setBookingCart('bookingCart', $bookingCartArr);
        return response()->json([
            'status' => true,
            'message' => ''
        ]);
    }

    public function show($id)
    {
        $SafeencryptionObj = new Safeencryption;
        $OrderID = $SafeencryptionObj->decode($id);
        $Order = Order::find($OrderID);
        if ($Order) {
            return view('checkout.thank-you', ['order' => $Order]);
        }
        return redirect()->route('home');
    }

    public function removeTempData($data)
    {

        if (isset($_COOKIE['searchGuestRoomCount'])) {
            unset($_COOKIE["searchGuestRoomCount"]);
            setcookie('searchGuestRoomCount', null, -1, '/');
        }
        if (isset($_COOKIE['searchGuestChildCount'])) {
            unset($_COOKIE["searchGuestChildCount"]);
            setcookie('searchGuestChildCount', null, -1, '/');
        }
        if (isset($_COOKIE['searchGuestAdultCount'])) {
            unset($_COOKIE["searchGuestAdultCount"]);
            setcookie('searchGuestAdultCount', null, -1, '/');
        }
        if (isset($_COOKIE['searchGuestArr'])) {
            unset($_COOKIE["searchGuestArr"]);
            setcookie('searchGuestArr', null, -1, '/');
        }
        if (isset($_COOKIE['search_from'])) {
            unset($_COOKIE["search_from"]);
            setcookie('search_from', null, -1, '/');
        }
        if (isset($_COOKIE['search_to'])) {
            unset($_COOKIE["search_to"]);
            setcookie('search_to', null, -1, '/');
        }
        if (isset($_COOKIE['location'])) {
            unset($_COOKIE["location"]);
            setcookie('location', null, -1, '/');
        }
        if (isset($_COOKIE['hidden_city_id'])) {
            unset($_COOKIE["hidden_city_id"]);
            setcookie('hidden_city_id', null, -1, '/');
        }
        if (isset($_COOKIE['country_id'])) {
            unset($_COOKIE["country_id"]);
            setcookie('country_id', null, -1, '/');
        }
        setBookingCart('bookingCart', array());

        return $data->forceDelete();
    }
}
