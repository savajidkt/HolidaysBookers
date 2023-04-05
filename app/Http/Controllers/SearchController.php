<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;

class SearchController extends Controller
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


    public function getLocations(Request $request)
    {
        $search = $request->search;
        $citiesData = [];
        if (strlen(trim($search)) > 0) {
            $citiesData = City::select('cities.*', 'countries.name as country')->leftJoin('countries', 'countries.id', '=', 'cities.country_id')->where('cities.status', City::ACTIVE)->where('cities.name', 'LIKE', '%' . $search . '%')->get();
        }
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $citiesData,
        ]);
    }

    public function ajaxHotelListing(Request $request)
    {
        
        if ($request->ajax()) {
            $page = $request->searchParam[0]['page'];
            $hotelList = "";
            $hotelCount = "";
            if (isset($request->searchParam) && strlen($request->searchParam[0]['city_id']) > 0 && $request->searchParam[0]['country_id'] > 0) {
                $searchParamArr = $request->searchParam[0];
                $hotelList = OfflineHotel::where('status', OfflineHotel::ACTIVE)->where('hotel_country', $searchParamArr['country_id'])->where('hotel_city', $searchParamArr['city_id'])->paginate(10);
                $hotelCount = OfflineHotel::where('status', OfflineHotel::ACTIVE)->where('hotel_type')->where('hotel_country', $searchParamArr['country_id'])->where('hotel_city', $searchParamArr['city_id'])->count();
            } else {
                $hotelList = OfflineHotel::where('status', OfflineHotel::ACTIVE)->paginate(10);
                $hotelCount = OfflineHotel::where('status', OfflineHotel::ACTIVE)->count();
            }
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'page'          => $page,
                'data'          => view('hotel.hotel-block-list', [
                    'hotelList'         => $hotelList,
                    'hotelCount'         => $hotelCount
                ])->render()
            ]);
        }
    }
}
