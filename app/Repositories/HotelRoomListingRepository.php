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

        $hotelRooms = OfflineRoom::whereHas('price', function ($query) use ($param) {
            $query->whereBetween('from_date', [$param['filterObjParamStartDate'], $param['filterObjParamEndDate']]);
        })->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $param['filterObjParamHotelID'])->get();
dd($hotelRooms);
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


        // foreach ($hotel->rooms as $key => $room) {
        //     $hotelRoomTempArray['room'] = $room->toArray();
        //     $hotelRoomTempArray['room']['amenities'] =  $room->roomamenity->toArray();
        //     $hotelRoomTempArray['room']['mealplans'] =  $room->mealplan->toArray();
        //     $hotelRoomTempArray['room']['freebies'] =  $room->roomfreebies->toArray();
        //     $hotelRoomTempArray['room']['images'] =  $room->images->toArray();
        //     $hotelRoomTempArray['room']['types'] =  $room->roomtype->toArray();
        //     $hotelRoomTempArray['room']['child'] = [];
        //     if ($room->price->count() > 0) {
        //         foreach ($room->price as $r_key => $r_room) {
        //             $roomArr = $r_room->toArray();
        //             $roomArr['price'] = numberFormat($r_room->price_p_n_single_adult, $r_room->currency->code);;
        //             $hotelRoomTempArray['room']['child'][] = $roomArr;
        //         }
        //     }
        //     $hotelsListingArray['roomDetails'][] = $hotelRoomTempArray;
        // }
        dd($hotelRooms);
        return $hotelRooms;
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
