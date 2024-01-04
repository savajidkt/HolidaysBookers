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

class CartController extends Controller
{

    protected $hotelListingRepository;
    protected $hotelRoomListingRepository;
    protected $checkoutRepository;
    public function __construct(HotelListingRepository $hotelListingRepository, HotelRoomListingRepository $hotelRoomListingRepository, CheckoutRepository $checkoutRepository)
    {
        $this->hotelListingRepository       = $hotelListingRepository;
        $this->hotelRoomListingRepository       = $hotelRoomListingRepository;
        $this->checkoutRepository       = $checkoutRepository;
    }

    public function index()
    {
        $bookingCartArr = getBookingCart('bookingCart');
        
        if ( is_array($bookingCartArr) && count($bookingCartArr) > 0) {
            return view('cart.index', ['bookingCartArr' => $bookingCartArr, 'hotelListingRepository' => $this->hotelListingRepository]);
        } else {
            return redirect()->route('home');
        }
    }

    public function removeCartHotel(Request $request)
    {
        $bookingCartArr = getBookingCart('bookingCart');
       

        if (is_array($bookingCartArr) && count($bookingCartArr) > 0) {

            foreach ($bookingCartArr as $bo_key => $bo_value) {
               
        $newTempArray = [];
                if ($bo_key == 'hotel') {
                    unset($bookingCartArr[$bo_key]);
                   
                    foreach ($bo_value as $key => $value) {
                if ($value['hotel_id'] == $request->hotel_id && $value['room_id'] == $request->hotel_room_id) {
                            unset($newTempArray[$key]);
                } else {
                    $newTempArray[] = $value;
                }
            }
                    if (count($newTempArray) > 0) {
                        $bookingCartArr['hotel'] = $newTempArray;
        }
                }
            }
        }

        //dd($bookingCartArr);
        setBookingCart('bookingCart', $bookingCartArr);
        return response()->json([
            'status' => true,
            'message' => ''
        ]);
    }
    public function removeCart()
    {
        $newTempArray = [];
        setBookingCart('bookingCart', $newTempArray);
        return response()->json([
            'status' => true,
            'message' => ''
        ]);
    }
    public function saveCartQuote()
    {
        $bookingCartArr = getBookingCart('bookingCart');
        return view('cart.index', ['bookingCartArr' => $bookingCartArr, 'hotelListingRepository' => $this->hotelListingRepository]);
    }
}
