<?php

namespace App\Http\Controllers;


use App\Models\City;
use App\Models\Amenity;
use App\Models\Country;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;

use App\Libraries\Safeencryption;
use App\Repositories\HotelListingRepository;
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
    public function __construct(HotelListingRepository $hotelListingRepository, HotelRoomListingRepository $hotelRoomListingRepository)
    {
        $this->hotelListingRepository       = $hotelListingRepository;
        $this->hotelRoomListingRepository       = $hotelRoomListingRepository;
    }

    public function index(Request $request)
    {               
        return view('checkout.checkout');        
    }   
}
