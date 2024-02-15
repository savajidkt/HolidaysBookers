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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        if ($request->search_from != null || $request->search_to != null) {
            $dateArr = explode(' - ', $request->daterange);
            $requestedArr['search_from'] = $dateArr[0];
           // $requestedArr['search_from'] = date('Y-m-d', strtotime($dateArr[0]));
           // $requestedArr['search_to'] = date('Y-m-d', strtotime($dateArr[1]));
            $requestedArr['search_to'] = $dateArr[1];
        }

        // $requestedArr['extra_data'] = getChildCount($request->all());   
        $requestedArr['adult'] = getSearchCookies('searchGuestAdultCount') ? getSearchCookies('searchGuestAdultCount') : 1;
        $requestedArr['child'] = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
        $requestedArr['room'] = getSearchCookies('searchGuestRoomCount') ? getSearchCookies('searchGuestRoomCount') : 1;
        $requestedArr['extra_data'] = getSearchCookies('searchGuestArr');

        $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
        $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));        
        $requestedArr['nights'] = dateDiffInDays($startDate, $endDate);
        $requestedArr['startDate'] = $startDate;
        $requestedArr['endDate'] = $endDate;
        $hotelListView = '';
       

        if( isset($request->selected_hotel_id) && $request->selected_hotel_id != NULL && $request->selected_hotel_id > 0 ){            
            $hotelListArray = $this->hotelListingRepository->hotelSelectedLists($request);
            if( $hotelListArray ){  
                $requestParam = [];
                $requestParam['requested_city_id'] = $request->city_id;
                $requestParam['requested_country_id'] = $request->country_id;
                $requestParam['requested_location'] = $request->location;
                $requestParam['requested_selected_hotel_id'] = $request->selected_hotel_id;
                $requestParam['requested_search_from'] = $request->search_from ? date('d/m/Y', strtotime($request->search_from)) : date('d/m/Y', strtotime(date('Y-m-d')));
                $requestParam['requested_search_to'] = $request->search_to ? date('d/m/Y', strtotime($request->search_to)) : date('d/m/Y', strtotime(date('Y-m-d')));                                    
                $hotelListView = view('hotel.hotel-block-list-single', [
                    'hotelList'         => $hotelListArray['data'],                    
                    'requestParam'          => $requestParam,
                'bookingCartArr' => getBookingCart('bookingCart')
                ])->render();
            }
        }    

        return view('hotel.hotel-list', ['requestedArr' => $requestedArr, 'country' => $country, 'amenitiesArr' => $amenitiesArr, 'hotelListView' =>$hotelListView]);
    }

    public function getLocations(Request $request)
    {
        $search = $request->search;
        $citiesData = [];
        $hotelData = [];
        $citiesArr = [];
        $hotelArr = [];
        if (strlen(trim($search)) > 0) {
            
            $citiesData = City::select('cities.*', 'countries.name as country')->leftJoin('countries', 'countries.id', '=', 'cities.country_id')->where('cities.status', City::ACTIVE)->where('cities.name', 'LIKE', $search . '%')->limit(20)->get();

            $hotelData = OfflineHotel::
            select('hotels.id as id','hotels.hotel_name as name', 'hotels.hotel_country as country_id','hotels.hotel_city as city_id', 'countries.name as country', 'cities.name as cities')
            ->leftJoin('countries', 'countries.id', '=', 'hotels.hotel_country')
            ->leftJoin('cities', 'cities.id', '=', 'hotels.hotel_city')
            ->where('hotels.hotel_name', 'LIKE', $search . '%')->get();
}

        if( $citiesData ){
            foreach ($citiesData as $key => $value) {
                $citiesArr[] = array(
                    'city_id'=> $value->id,
                    'city'=> $value->name,
                    'country'=> $value->country,
                    'country_id'=> $value->country_id
                );                        
            }
        }
        if( $hotelData ){
            foreach ($hotelData as $key => $value) {
                $hotelArr[] = array(
                    'hotel_id'=> $value->id,
                    'city_id'=> $value->city_id,
                    'hotel_name'=> $value->name,
                    'city'=> $value->cities,
                    'country'=> $value->country,                    
                    'country_id'=> $value->country_id,
                );                        
            }
        }
        return response()->json([
            'status' => true,
            'message' => '',
            'data' => $citiesArr,
            'hotelData' => $hotelArr,
        ]);
    }

    public function ajaxHotelListing(Request $request)
    {

        if ($request->ajax()) {
            $SafeencryptionObj = new Safeencryption;
            $page = $request->page;
            $hotelListArray = $this->hotelListingRepository->hotelLists($request);
           
           
            $hotelCount = $this->hotelListingRepository->hotelCount($request);            
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
                   'bookingCartArr' => getBookingCart('bookingCart')
                ])->render()
            ]);
        }
    }

    public function ajaxRoomListing(Request $request)
    {
        if ($request->ajax()) {
            $hotelRooms = $this->hotelRoomListingRepository->hotelRoomLists($request->all());  
            
            $SafeencryptionObj = new Safeencryption;
            return response()->json([
                'status'        => 200,
                'message'       => 'successfully.',
                'data'          => view('hotel.hotel-rooms-block-list', [
                    'hotelRooms'         => $hotelRooms,
                    'requestParam'          => $request->all(),
                    'bookingCartArr' => getBookingCart('bookingCart'),
                    'safeencryptionObj' =>  $SafeencryptionObj,
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
        $hotelsRoomDetails = $this->hotelListingRepository->hotelDetails($requestParam['hotel_id']);
        
        if (!$hotelsRoomDetails) {
            return redirect()->route('home');
        }
        $hotelsDetails = $this->hotelListingRepository->hotelDetailsArr($requestParam['hotel_id']);
        
        if ($hotelsDetails) {
            $hotelsRelated = $this->hotelListingRepository->hotelRelated($hotelsDetails['hotel']);
        }
       
     
        return view('hotel.hotel-details', ['requestedArr' => $requestParam, 'hotelsDetails' => $hotelsDetails, 'hotelsRoomDetails' => $hotelsRoomDetails, 'hotelsRelated' => $hotelsRelated, 'safeencryptionObj' => $safeencryptionObj, 'requestParam' => $requestParam, 'id' => $id, 'bookingCartArr' => getBookingCart('bookingCart')]);
    }
}
