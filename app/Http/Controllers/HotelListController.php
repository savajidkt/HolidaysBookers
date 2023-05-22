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

class HotelListController extends Controller
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
        }

        if( $request->search_from == null || $request->search_to == null ){
            $dateArr = explode(' - ', $request->daterange);
            $requestedArr['search_from'] = date('Y-m-d', strtotime($dateArr[0]));
            $requestedArr['search_to'] = date('Y-m-d', strtotime($dateArr[1]));
        }

        // $requestedArr['extra_data'] = getChildCount($request->all());   
        $requestedArr['adult'] = getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 1;
        $requestedArr['child'] = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
        $requestedArr['room'] = getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 1;
        $requestedArr['extra_data'] = getSearchCookies('searchGuestArr');
        

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
            $SafeencryptionObj = new Safeencryption;
            $page = $request->page;
            $hotelListArray = $this->hotelListingRepository->hotelLists($request);
           
            $hotelCount = $this->hotelListingRepository->hotelCount($request);
            //$hotelList = (object) $hotelListArray;
            //$hotelList->loadMissing(['rooms']);
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'page'          => $page,
                'count'          => $hotelCount,

                'data'          => view('hotel.hotel-block-list', [
                    'hotelList'         => $hotelListArray['data'],
                    'hotelListModel'         => $hotelListArray['model'],
                    'hotelCount'         => $hotelCount,
                    'safeencryptionObj'          => $SafeencryptionObj,
                    'requestParam'          => $request->all(),
                ])->render()
            ]);
        }
    }

    public function ajaxRoomListing(Request $request)
    {
        if ($request->ajax()) {
            $hotelRooms = $this->hotelRoomListingRepository->hotelRoomLists($request->all());
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'data'          => view('hotel.hotel-rooms-block-list', [
                    'hotelRooms'         => $hotelRooms
                ])->render()
            ]);
        }
    }

    public function show($id)
    {
        $safeencryptionObj = new Safeencryption;
       
        $requestParam = unserialize($safeencryptionObj->decode($id));
      
        if (!$requestParam['hotel_id']) {
            return redirect()->route('home');
        }

        $hotelsRelated = [];
        $hotelsDetails = $this->hotelListingRepository->hotelDetails($requestParam['hotel_id']);

        if ($hotelsDetails) {
            $hotelsRelated = $this->hotelListingRepository->hotelRelated($hotelsDetails['hotel']);
        }


        return view('hotel.hotel-details', ['hotelsDetails' => $hotelsDetails, 'hotelsRelated' => $hotelsRelated, 'safeencryptionObj' => $safeencryptionObj, 'requestParam' => $requestParam]);
    }
}
