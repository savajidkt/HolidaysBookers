<?php

namespace App\Http\Controllers;

use App\Models\OfflineHotel;
use Illuminate\Http\Request;

class HotelListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }


    public function index()
    {
        $hotelList = OfflineHotel::where('status', OfflineHotel::ACTIVE)->paginate(10);
        $hotelCount = OfflineHotel::where('status', OfflineHotel::ACTIVE)->where('hotel_type', OfflineHotel::OFFLINE)->count();
        //$hotelCount = OfflineHotel::where('status', OfflineHotel::ACTIVE)->where('hotel_type', OfflineHotel::OFFLINE)->count();
        return view('hotel-list', ['hotelList' => $hotelList, 'hotelCount' => $hotelCount]);
    }
}
