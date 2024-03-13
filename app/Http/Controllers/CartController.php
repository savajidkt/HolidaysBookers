<?php

namespace App\Http\Controllers;


use Session;
use App\Models\City;
use App\Models\User;
use App\Models\Order;
use Razorpay\Api\Api;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\Cart;

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
                        if ($value['hotel_id'] == $request->hotel_id && $value['room_id'] == $request->hotel_room_id && $value['unique_id'] == $request->key_id) {
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

        $user_id = Auth::id();
        $isCartExist = Cart::where('user_id', $user_id)->where('status','1')->first();
        
        if( $isCartExist ){             
            Cart::where('user_id',$user_id)->update(['cartData' => serialize($bookingCartArr)]);          
        } else {
            $dataSave = [
                'user_id'    => $user_id,
                'cartData'    => serialize($bookingCartArr)                
            ];            
            Cart::create($dataSave);
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
        $user_id = Auth::id();
        $isCartExist = Cart::where('user_id', $user_id)->where('status','1')->first();
        
        if( $isCartExist ){             
            Cart::where('user_id',$user_id)->update(['cartData' => serialize($newTempArray)]);          
        } else {
            $dataSave = [
                'user_id'    => $user_id,
                'cartData'    => serialize($newTempArray)                
            ];            
            Cart::create($dataSave);
        }
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
