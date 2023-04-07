<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\City;
use App\Models\Country;
use App\Models\OfflineRoom;
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
            $hotelList = "";
            $hotelCount = "";
            $hotel_amenities = "";
            $room_amenities = "";
            if (strlen($request->hotel_amenities) > 0) {
                $hotel_amenities = trim($request->hotel_amenities, ', ');
            }
            if (strlen($request->room_amenities) > 0) {
                $room_amenities = trim($request->room_amenities, ', ');
            }
            if (isset($request->requested_city_id) && strlen($request->requested_city_id) > 0 && $request->requested_country_id > 0) {

                if (strlen($hotel_amenities) > 0) {
                   
                    $hotelList = OfflineHotel::with('hotelamenity')
                        ->whereHas('hotelamenity', function ($query) use ($hotel_amenities) {
                            $query->whereIn('amenities_id', explode(', ', $hotel_amenities));
                        })
                        ->where(function ($query) use ($request) {
                            if (strlen($request->star) > 0) {
                                $query->where('hotels.category', '<=', $request->star);
                            }
                        })
                        ->where('hotel_country', $request->requested_country_id)
                        ->where('hotel_city', $request->requested_city_id)
                        ->paginate(10);
                    $hotelCount = OfflineHotel::with('hotelamenity')
                        ->whereHas('hotelamenity', function ($query) use ($hotel_amenities) {
                            $query->whereIn('amenities_id', explode(', ', $hotel_amenities));
                        })
                        ->where(function ($query) use ($request) {
                            if (strlen($request->star) > 0) {
                                $query->where('hotels.category', '<=', $request->star);
                            }
                        })
                        ->where('hotel_country', $request->requested_country_id)
                        ->where('hotel_city', $request->requested_city_id)
                        ->count();
                } else {
                    
                    $hotelList = OfflineHotel::where(function ($query) use ($request) {
                        if (strlen($request->star) > 0) {
                            $query->where('hotels.category', '<=', $request->star);
                        }
                    })
                        ->where('status', OfflineHotel::ACTIVE)
                        ->where('hotel_country', $request->requested_country_id)
                        ->where('hotel_city', $request->requested_city_id)
                        ->paginate(10);
                    $hotelCount = OfflineHotel::where(function ($query) use ($request) {
                        if (strlen($request->star) > 0) {
                            $query->where('hotels.category', '<=', $request->star);
                        }
                    })
                        ->where('status', OfflineHotel::ACTIVE)
                        ->where('hotel_country', $request->requested_country_id)
                        ->where('hotel_city', $request->requested_city_id)
                        ->count();
                }
            } else {
                if (strlen($hotel_amenities) > 0) {
                    $hotelList = OfflineHotel::with('hotelamenity')
                        ->whereHas('hotelamenity', function ($query) use ($hotel_amenities, $request) {
                            $query->whereIn('amenities_id', explode(', ', $hotel_amenities));
                        })
                        ->where(function ($query) use ($request) {
                            if (strlen($request->star) > 0) {
                                $query->where('hotels.category', '<=', $request->star);
                            }
                        })
                        ->paginate(10);
                    $hotelCount = OfflineHotel::with('hotelamenity')
                        ->whereHas('hotelamenity', function ($query) use ($hotel_amenities) {
                            $query->whereIn('amenities_id', explode(', ', $hotel_amenities));
                        })
                        ->where(function ($query) use ($request) {
                            if (strlen($request->star) > 0) {
                                $query->where('hotels.category', '<=', $request->star);
                            }
                        })
                        ->count();
                } else {
                    $hotelList = OfflineHotel::where(function ($query) use ($request) {
                        if (strlen($request->star) > 0) {
                            $query->where('hotels.category', '<=', $request->star);
                        }
                    })
                        ->where('status', OfflineHotel::ACTIVE)
                        ->paginate(10);
                    $hotelCount = OfflineHotel::where(function ($query) use ($request) {
                        if (strlen($request->star) > 0) {
                            $query->where('hotels.category', '<=', $request->star);
                        }
                    })
                        ->where('status', OfflineHotel::ACTIVE)
                        ->count();
                }
            }
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
