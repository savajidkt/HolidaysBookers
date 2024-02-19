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
use App\Models\DraftOrder;
use App\Models\QuoteOrder;
use App\Notifications\QuoteOrderNotification;
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
            return view('checkout.checkout', ['hotelListingRepository' =>$this->hotelListingRepository,'hotelsDetails' =>[], 'offlineRoom' => [], 'requiredParamArr' => $requiredParamArr, 'bookingKey' => '', 'extraData' => [], 'user' => auth()->user()]);
        } else {
            return redirect()->route('home');
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

        
        if ($request->button_name == "Quote") {

            $res = $this->saveAsQuote($request);
            if ($res) {
                return redirect()->route('agent.quotation')->with('success', 'Your booking quote created successfully!');
            } else {
                return redirect()->route('agent.quotation')->with('error', 'Your booking quote created failed!');
            }
        } else if ($request->button_name == "Draft") {

            $res = $this->saveAsDraft($request);
            if ($res) {
                return redirect()->route('agent.draft')->with('success', 'Your booking draft created successfully!');
            } else {
                return redirect()->route('agent.draft')->with('error', 'Your booking draft created failed!');
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
            dd($request->all());
            //Pay On Online payment            
            $dataObj = $this->checkoutRepository->createBooking($request->all());
            return view('checkout.rozarpay', ['requestData' => $request->all(), 'dataObj' => $dataObj]);
        }
        }
        //return redirect()->route('checkout.show', [])->with('error', 'Your booking created successfully!');

    }

    public function saveAsQuote($request)
    {        
        $data = $this->checkoutRepository->createBookingQuote($request->all());
        $res = $this->checkoutRepository->createOrderBookingQuote($data);
        
        if ($res) {
            $this->removeTempData($data);
            return true;
        }
        return false;
    }

    public function saveAsDraft($request)
    {
      

        $data = $this->checkoutRepository->createBookingDraft($request->all());
        $res = $this->checkoutRepository->createOrderBookingDraft($data);
        if ($res) {
            $this->removeTempData($data);
            return true;
        }
        return false;
    }

    public function SendEmailQuotePDF($res)
    {
        $QuoteOrder = new QuoteOrder();
        $QuoteOrder->notify(new QuoteOrderNotification($res));
        return redirect()->route('contact-us')->with('success', 'Thank you for contact us. we will contact you shortly.');
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
        $WalletTransaction = $this->PayForAgentWallet($data);
        if ($WalletTransaction) {
           // dd($WalletTransaction->id);
           // dd($WalletTransaction->id);
            return $this->checkoutRepository->createOrderBooking($data,'',$WalletTransaction->id);
        }
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
        $cartsArr = $this->createCartData($requiredParamArr);
        // dd($cartsArr);
        setBookingCart('bookingCart', $cartsArr);
        return response()->json([
            'status' => true,
            'redirectURL' => route('cart'),
            'message' => '',
            'cartItem' => getCartTotalItem()
        ]);
    }

    public function createCartData($requiredParamArr)
    {

        $today = date("YmdHis");
        $uniqueId= $today.'_'.mt_rand();
        
        $oldCart = getBookingCart('bookingCart');
        //$requiredParamArr['is_type'] = "package";
        if (is_array($requiredParamArr) && count($requiredParamArr) > 0) {

            $requiredParamArr['unique_id'] = $uniqueId;
            if ($requiredParamArr['is_type'] == "hotel") {
                if (is_array($oldCart) && count($oldCart) > 0) {
                    if (isset($oldCart['hotel'])) {
                        $oldCart['hotel'][] = $requiredParamArr;
                    } else {
                        $oldCart['hotel'][] = $requiredParamArr;
                    }
                } else {
                    $oldCart['hotel'][] = $requiredParamArr;
                }
            } else if ($requiredParamArr['is_type'] == "package") {
                if (is_array($oldCart) && count($oldCart) > 0) {
                    if (isset($oldCart['package'])) {
                        $oldCart['package'][] = $requiredParamArr;
                    } else {
                        $oldCart['package'][] = $requiredParamArr;
                    }
                } else {
                    $oldCart['package'][] = $requiredParamArr;
                }
            } else if ($requiredParamArr['is_type'] == "sightseeing") {
                if (is_array($oldCart) && count($oldCart) > 0) {
                    if (isset($oldCart['sightseeing'])) {
                        $oldCart['sightseeing'][] = $requiredParamArr;
                    } else {
                        $oldCart['sightseeing'][] = $requiredParamArr;
                    }
                } else {
                    $oldCart['sightseeing'][] = $requiredParamArr;
                }
            } else if ($requiredParamArr['is_type'] == "transfer") {
                if (is_array($oldCart) && count($oldCart) > 0) {
                    if (isset($oldCart['transfer'])) {
                        $oldCart['transfer'][] = $requiredParamArr;
                    } else {
                        $oldCart['transfer'][] = $requiredParamArr;
                    }
                } else {
                    $oldCart['transfer'][] = $requiredParamArr;
                }
            }
        }
        return $oldCart;
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
        if (isset($_COOKIE['dateHomeDay'])) {
            unset($_COOKIE["dateHomeDay"]);
            setcookie('dateHomeDay', null, -1, '/');
        }
        if (isset($_COOKIE['countryName'])) {
            unset($_COOKIE["countryName"]);
            setcookie('countryName', null, -1, '/');
        }
        setBookingCart('bookingCart', array());

        return $data->forceDelete();
    }

    public function quoteTempStore(Request $request)
    {
        $QuoteOrder = QuoteOrder::find($request->order_id);
       
        if ($QuoteOrder) {
            $this->getAddToCartHotelData($request, $QuoteOrder);
        }
        return redirect()->back()->with('success', 'Add to cart successfully!');
    }

    public function draftTempStore(Request $request)
    {
        
        $DraftOrder = DraftOrder::find($request->order_id);
       
        if ($DraftOrder) {
           
            $this->getAddToCartHotelDataDraft($request, $DraftOrder);
        }
        return redirect()->back()->with('success', 'Add to cart successfully!');
    }

    public function getAddToCartHotelData($request, $QuoteOrder)
    {

        
        $requiredParamArr = [];
        foreach ($QuoteOrder->quote_hotel as $hotel_key => $hotel_value) {           
            $requiredParamArr['is_type'] = "hotel";           
            foreach ($hotel_value->order_hotel_room as $room_key => $room_value) {
                $child_extraArr = unserialize($room_value->child_extra);
                if ($request->order_type == "single" && $request->order_id ==  $room_value->quote_id && $request->order_room_id == $room_value->id) {
                    dd($room_value->child_extra);
                    $requiredParamArr['hotel_id'] = $room_value->hotel_id;
                    $requiredParamArr['room_id'] = $room_value->room_id;
                    $requiredParamArr['price_id'] = $room_value->room_price_id;
                    $requiredParamArr['adult'] = $room_value->adult;
                    $requiredParamArr['child'] = $room_value->child;
                    $requiredParamArr['room_child_age'] = $child_extraArr;
                    $requiredParamArr['room'] = 1;
                    $requiredParamArr['city_id'] = "";
                    $requiredParamArr['search_from'] = dateFormat( str_replace('/', '-', $room_value->check_in_date),'Y-m-d');
                    $requiredParamArr['search_to'] = dateFormat( str_replace('/', '-', $room_value->check_out_date),'Y-m-d');
                    $requiredParamArr['originAmount'] = $room_value->origin_amount;
                    $requiredParamArr['productMarkupAmount'] = $room_value->product_markup_amount;
                    $requiredParamArr['agentMarkupAmount'] = $room_value->agent_markup_amount;
                    $requiredParamArr['agentGlobalMarkupAmount'] = $room_value->agent_global_markup_amount;
                    $requiredParamArr['finalAmount'] = $room_value->price;                    
                    $cartsArr = $this->createCartData($requiredParamArr);
                    setBookingCart('bookingCart', $cartsArr);
                } else {                                        
                    $requiredParamArr['hotel_id'] = $room_value->hotel_id;
                    $requiredParamArr['room_id'] = $room_value->room_id;
                    $requiredParamArr['price_id'] = $room_value->room_price_id;
                    $requiredParamArr['adult'] = $room_value->adult;
                    $requiredParamArr['child'] = $room_value->child;
                    $requiredParamArr['room_child_age'] = $child_extraArr;

                    $requiredParamArr['room'] = 1;
                    $requiredParamArr['city_id'] = "";
                    $requiredParamArr['search_from'] = dateFormat( str_replace('/', '-', $room_value->check_in_date),'Y-m-d');
                    $requiredParamArr['search_to'] = dateFormat( str_replace('/', '-', $room_value->check_out_date),'Y-m-d');
                    
                    $requiredParamArr['originAmount'] = $room_value->origin_amount;
                    $requiredParamArr['productMarkupAmount'] = $room_value->product_markup_amount;
                    $requiredParamArr['agentMarkupAmount'] = $room_value->agent_markup_amount;
                    $requiredParamArr['agentGlobalMarkupAmount'] = $room_value->agent_global_markup_amount;
                    $requiredParamArr['finalAmount'] = $room_value->price;                    
                    $cartsArr = $this->createCartData($requiredParamArr);                    
                    setBookingCart('bookingCart', $cartsArr);
                }
            }
        }
        return true;
    }

    public function getAddToCartHotelDataDraft($request, $DraftOrder)
    {

        $requiredParamArr = [];
        
        foreach ($DraftOrder->draft_hotel as $hotel_key => $hotel_value) {
            $requiredParamArr['is_type'] = "hotel";
           
            foreach ($hotel_value->order_hotel_room as $room_key => $room_value) {
                if ($request->order_type == "single" && $request->order_id ==  $room_value->draft_id && $request->order_room_id == $room_value->id) {
                    $requiredParamArr['hotel_id'] = $room_value->hotel_id;
                    $requiredParamArr['room_id'] = $room_value->room_id;
                    $requiredParamArr['price_id'] = $room_value->room_price_id;
                    $requiredParamArr['adult'] = $room_value->adult;
                    $requiredParamArr['child'] = $room_value->check_in_date;
                    $requiredParamArr['room'] = 1;
                    $requiredParamArr['city_id'] = "";
                    $requiredParamArr['search_from'] = $room_value->check_in_date;
                    $requiredParamArr['search_to'] = $room_value->check_out_date;
                    $requiredParamArr['originAmount'] = $room_value->origin_amount;
                    $requiredParamArr['productMarkupAmount'] = $room_value->product_markup_amount;
                    $requiredParamArr['agentMarkupAmount'] = $room_value->agent_markup_amount;
                    $requiredParamArr['agentGlobalMarkupAmount'] = $room_value->agent_global_markup_amount;
                    $requiredParamArr['finalAmount'] = $room_value->price;
                    $cartsArr = $this->createCartData($requiredParamArr);
                    setBookingCart('bookingCart', $cartsArr);
                } else {
                    $requiredParamArr['hotel_id'] = $room_value->hotel_id;
                    $requiredParamArr['room_id'] = $room_value->room_id;
                    $requiredParamArr['price_id'] = $room_value->room_price_id;
                    $requiredParamArr['adult'] = $room_value->adult;
                    $requiredParamArr['child'] = $room_value->check_in_date;
                    $requiredParamArr['room'] = 1;
                    $requiredParamArr['city_id'] = "";
                    $requiredParamArr['search_from'] = $room_value->check_in_date;
                    $requiredParamArr['search_to'] = $room_value->check_out_date;
                    $requiredParamArr['originAmount'] = $room_value->origin_amount;
                    $requiredParamArr['productMarkupAmount'] = $room_value->product_markup_amount;
                    $requiredParamArr['agentMarkupAmount'] = $room_value->agent_markup_amount;
                    $requiredParamArr['agentGlobalMarkupAmount'] = $room_value->agent_global_markup_amount;
                    $requiredParamArr['finalAmount'] = $room_value->price;
                    $cartsArr = $this->createCartData($requiredParamArr);
                    setBookingCart('bookingCart', $cartsArr);
                }
            }
        }
        return true;
    }
}
