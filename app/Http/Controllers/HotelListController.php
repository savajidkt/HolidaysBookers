<?php

namespace App\Http\Controllers;

use App\Models\Country;
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


    public function index(Request $request)
    {        
        $country =  [];
        $requestedArr = [];
        if (isset($request->country_id)) {
            $country = Country::find($request->country_id);
            $requestedArr = $request->all();
        } else {
            $requestedArr['location'] = "";
            $requestedArr['city_id'] = "";
            $requestedArr['country_id'] = "";
            $requestedArr['search_from'] = "";
            $requestedArr['search_to'] = "";
            $requestedArr['adult'] = 0;
            $requestedArr['child'] = 0;
            $requestedArr['room'] = 0;
        } 

        
        return view('hotel.hotel-list', ['requestedArr' => $requestedArr, 'country' => $country]);
    }
}
