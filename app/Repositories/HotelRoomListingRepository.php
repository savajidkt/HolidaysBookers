<?php

namespace App\Repositories;

use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelRoomListingRepository
{

    public function hotelRoomLists(array $param)
    {


        $hotelRooms = OfflineRoom::with(['price'])->where(function ($query) use ($param) {
            if (strlen($param['filterObjParamStartDate']) > 0 && strlen($param['filterObjParamEndDate']) > 0) {
                $query->whereHas('price', function ($query) use ($param) {

                    $startDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamStartDate']);
                    $endDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamEndDate']);
                    $query->whereDate('from_date','<=', $startDate);
                    $query->whereDate('to_date','>=', $endDate);
                    //$query->where('price_type1','!=',OfflineRoomPrice::STOPSALE);
                });

                $query->doesntHave('price', function ($query) use ($param) {
                   dd(OfflineRoomPrice::STOPSALE);
                    $query->where('price_type',OfflineRoomPrice::STOPSALE);
                });

                
                //$query->orderBy('price_p_n_single_adult')->orderBy('price_p_n_single_adult','asc');
            }
        })->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $param['filterObjParamHotelID'])->get();
        $hotelRooms->loadMissing('price');
        //dd($hotelRooms);

        // whereHas('price', function ($query) use ($param) {
        //     $query->whereBetween('from_date', [$param['filterObjParamStartDate'], $param['filterObjParamEndDate']]);
        // })->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $param['filterObjParamHotelID'])->get();

        // ->where(function ($query) use ($param) {
        //     if (strlen($param['filterObjParamAdult']) > 0 && strlen($param['filterObjParamAdult']) > 0) {
        //         $query->where('hotels.hotel_country', '=', $param['filterObjParamAdult']);
        //     }
        // })
        // ->where(function ($query) use ($param) {
        //     if (strlen($param['filterObjParamChild']) > 0 && strlen($param['filterObjParamChild']) > 0) {
        //         $query->where('hotels.hotel_country', '=', $param['filterObjParamChild']);
        //     }
        // })
        // ->where(function ($query) use ($param) {
        //     if (strlen($param['filterObjParamRoom']) > 0 && strlen($param['filterObjParamRoom']) > 0) {
        //         $query->where('hotels.hotel_country', '=', $param['filterObjParamRoom']);
        //     }
        // })
        // ->where(function ($query) use ($param) {
        //     if (strlen($param['filterObjParamStartPrice']) > 0 && strlen($param['filterObjParamStartPrice']) > 0) {
        //         $query->where('hotels.hotel_country', '=', $param['filterObjParamStartPrice']);
        //     }
        // })
        // ->where(function ($query) use ($param) {
        //     if (strlen($param['filterObjParamEndPrice']) > 0 && strlen($param['filterObjParamEndPrice']) > 0) {
        //         $query->where('hotels.hotel_country', '=', $param['filterObjParamEndPrice']);
        //     }
        // })
        // ->where('status', OfflineRoom::ACTIVE)
        //->where('hotel_id', $param['filterObjParamHotelID'])->get();        

        // $hotelsListingArray = [];
        // $hotelsListingArray['hotel'] = $hotel->toArray();
        // $hotelsListingArray['hotel']['hotel_amenities'] = $hotel->hotelamenity->toArray();
        // $hotelsListingArray['hotel']['hotel_freebies'] = $hotel->hotelfreebies->toArray();
        // $hotelsListingArray['hotel']['hotel_groups'] =  $hotel->hotelgroup->toArray();
        // $hotelsListingArray['hotel']['hotel_images'] = $hotel->images->toArray();

        // $roomsIds = $hotel->rooms->pluck('id')->toArray();
        // $roomPrice = OfflineRoomPrice::whereIn('room_id',$roomsIds)->orderBy('price_p_n_single_adult')->limit(1)->first();
        // if($roomPrice){           
        //     $hotelsListingArray['hotel']['price'] = numberFormat($roomPrice->price_p_n_single_adult,$roomPrice->currency->code);
        // }   

        $roomListingArray=[];
        $roomPriceListingArray=[];
        foreach ($hotelRooms as $key => $roomPrice) {
            $roomPriceListingArray=[];
            $roomListingArray[$key]['hotel_id'] = $roomPrice->hotel_id;
            $roomListingArray[$key]['room_id'] = $roomPrice->id;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            //$roomPriceListingArray = $roomPrice->price->toArray();

            // room price array loop
            foreach($roomPrice->price as $pkey=> $price){
                $roomPriceListingArray[$pkey]['price_id'] = $price->id;
                $roomPriceListingArray[$pkey]['meal_plan'] = $price->mealplan->name;
                $roomPriceListingArray[$pkey]['currency'] = $price->currency->code;
                $roomPriceListingArray[$pkey]['price_p_n_single_adult'] = numberFormat($price->price_p_n_single_adult);
                
            }

            usort($roomPriceListingArray, function ($item1, $item2) {
                return $item1['price_p_n_single_adult'] <=> $item2['price_p_n_single_adult'];
            });
            $roomListingArray[$key]['room_price'] = $roomPriceListingArray;
            
            
        }
        return $roomListingArray;
    }

    public function hotelRelated(array $hotelsDetails)
    {
        $hotels = OfflineHotel::where('hotels.hotel_city', '=', $hotelsDetails['hotel_city'])->where('hotels.id', '!=', $hotelsDetails['id'])->limit(5)->get();

        $hotelsListingArray = [];
        foreach ($hotels as $key => $hotel) {
            $hotelsListingArray[$key]['id'] = $hotel->id;
            $hotelsListingArray[$key]['hotel_country'] = $hotel->country->name;
            $hotelsListingArray[$key]['hotel_city'] = $hotel->city->name;
            $hotelsListingArray[$key]['property_type_id'] = $hotel->property->property_name;
            $hotelsListingArray[$key]['hotel_name'] = $hotel->hotel_name;
            $hotelsListingArray[$key]['hotel_address'] = $hotel->hotel_address;
            $hotelsListingArray[$key]['currency'] = $hotel->currency;
            $hotelsListingArray[$key]['hotel_image_location'] = $hotel->hotel_image_location;
            $hotelsListingArray[$key]['hotel_review'] = $hotel->hotel_review;
            $hotelRoomArray = [];
            $roomsIds = $hotel->rooms->pluck('id')->toArray();

            $roomPrice = OfflineRoomPrice::whereIn('room_id', $roomsIds)->orderBy('price_p_n_single_adult')->limit(1)->first();
            $hotelsListingArray[$key]['hotel_amenities'] = $hotel->hotelamenity->toArray();
            $hotelsListingArray[$key]['hotel_images'] = $hotel->images->toArray();

            if ($roomPrice) {
                $hotelRoomArray['room_id'] = $roomPrice->room_id;
                $hotelRoomArray['room_name'] = $roomPrice->room->roomtype->room_type;
                $hotelRoomArray['occ_num_beds'] = $roomPrice->room->occ_num_beds;
                $hotelRoomArray['min_nights'] = $roomPrice->min_nights;
                $hotelRoomArray['occ_max_adults'] = $roomPrice->room->occ_max_adults;
                $hotelRoomArray['price'] = numberFormat($roomPrice->price_p_n_single_adult, $roomPrice->currency->code);
            }
            $hotelsListingArray[$key]['room'] = $hotelRoomArray;
        }
        return $hotelsListingArray;
    }
}
