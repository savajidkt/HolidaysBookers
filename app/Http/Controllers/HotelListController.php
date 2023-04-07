<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\OfflineRoom;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use App\Repositories\HotelListingRepository;

class HotelListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $hotelListingRepository;
    public function __construct(HotelListingRepository $hotelListingRepository)
    {
        $this->hotelListingRepository       = $hotelListingRepository;
    }

    public function index(Request $request)
    {
        $country =  [];
        $requestedArr = [];
        $amenitiesArr = Amenity::all();
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


        return view('hotel.hotel-list', ['requestedArr' => $requestedArr, 'country' => $country, 'amenitiesArr' => $amenitiesArr]);
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
            $page = $request->page;
            $hotelList = $this->hotelListingRepository->hotelLists($request);
            $hotelCount = $this->hotelListingRepository->hotelCount($request);
            //$hotelList->loadMissing(['rooms']);
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'page'          => $page,
                'count'          => $hotelCount,
                'data'          => view('hotel.hotel-block-list', [
                    'hotelList'         => $hotelList,
                    'hotelCount'         => $hotelCount
                ])->render()
            ]);
        }
    }

    public function ajaxRoomListing(Request $request)
    {

        if ($request->ajax()) {
            $hotelRooms = OfflineRoom::where('status', OfflineRoom::ACTIVE)->where('hotel_id', $request->id)->get();
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'data'          => view('hotel.hotel-rooms-block-list', [
                    'hotelRooms'         => $hotelRooms
                ])->render()
            ]);
        }
    }
}
