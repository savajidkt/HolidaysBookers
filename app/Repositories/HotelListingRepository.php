<?php

namespace App\Repositories;

use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelListingRepository
{



    public function hotelLists($request)
    {        
        $hotels = OfflineHotel::with(['rooms.price'])->where(function ($query) use ($request) {
            if (strlen($request->hotel_amenities) > 0) {
                $query->whereHas('hotelamenity', function ($query) use ($request) {
                    $query->whereIn('amenities_id', explode(', ', $request->hotel_amenities));
                });
            }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_country_id) > 0) {
                    $query->where('hotels.hotel_country', '=', $request->requested_country_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_city_id) > 0) {
                    $query->where('hotels.hotel_city', '=', $request->requested_city_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->star) > 0) {
                    $query->where('hotels.category', '<=', $request->star);
                }
            })
            ->paginate(10);
        $hotelsListingArray = [];
        foreach($hotels as $key=>$hotel){
            $hotelsListingArray[$key]['id'] = $hotel->id;
            $hotelsListingArray[$key]['hotel_country'] = $hotel->country->name;
            $hotelsListingArray[$key]['hotel_city'] = $hotel->city->name;
            $hotelsListingArray[$key]['hotel_group_id'] = $hotel->hotelgroup->name;
            $hotelsListingArray[$key]['property_type_id'] = $hotel->property->property_name;
            $hotelsListingArray[$key]['api_id'] = $hotel->api_id;
            $hotelsListingArray[$key]['hotel_code'] = $hotel->hotel_code;
            $hotelsListingArray[$key]['hotel_name'] = $hotel->hotel_name;
            $hotelsListingArray[$key]['category'] = $hotel->category;
            $hotelsListingArray[$key]['phone_number'] = $hotel->phone_number;
            $hotelsListingArray[$key]['fax_number'] = $hotel->fax_number;
            $hotelsListingArray[$key]['hotel_address'] = $hotel->hotel_address;
            $hotelsListingArray[$key]['hotel_pincode'] = $hotel->hotel_pincode;
            $hotelsListingArray[$key]['currency'] = $hotel->currency;
            $hotelsListingArray[$key]['hotel_image_location'] = $hotel->hotel_image_location;
            $hotelsListingArray[$key]['hotel_description'] = $hotel->hotel_description;
            $hotelsListingArray[$key]['hotel_review'] = $hotel->hotel_review;
            $hotelsListingArray[$key]['hotel_email'] = $hotel->hotel_email;
            $hotelsListingArray[$key]['hotel_latitude'] = $hotel->hotel_latitude;
            $hotelsListingArray[$key]['hotel_longitude'] = $hotel->hotel_longitude;
            $hotelsListingArray[$key]['is_new'] = $hotel->is_new;
            $hotelsListingArray[$key]['cancel_days'] = $hotel->cancel_days;
            $hotelsListingArray[$key]['cancellation_policy'] = $hotel->cancellation_policy;
            $hotelsListingArray[$key]['hotel_type'] = $hotel->hotel_type;
            $hotelRoomArray =[];
            $roomsIds = $hotel->rooms->pluck('id')->toArray();

            $roomPrice = OfflineRoomPrice::whereIn('room_id',$roomsIds)->orderBy('price_p_n_single_adult')->limit(1)->first();
            $hotelsListingArray[$key]['hotel_amenities'] = $hotel->hotelamenity->toArray();
            $hotelsListingArray[$key]['hotel_groups'] =  $hotel->hotelgroup->toArray();
            $hotelsListingArray[$key]['hotel_images'] = $hotel->images->toArray();
            if($roomPrice){
                $hotelRoomArray['room_id'] = $roomPrice->room_id;
                $hotelRoomArray['room_name'] = $roomPrice->room->roomtype->room_type;
                $hotelRoomArray['occ_num_beds'] = $roomPrice->room->occ_num_beds;
                $hotelRoomArray['min_nights'] = $roomPrice->min_nights;
                $hotelRoomArray['occ_max_adults'] = $roomPrice->room->occ_max_adults;
                $hotelRoomArray['price'] = numberFormat($roomPrice->price_p_n_single_adult,$roomPrice->currency->code);
            }
            
            
            
           
            $hotelsListingArray[$key]['room'] = $hotelRoomArray;

        }
       
        return ['model'=>$hotels,'data'=>$hotelsListingArray];
    }

    public function hotelCount($request)
    {
        return OfflineHotel::where(function ($query) use ($request) {
            if (strlen($request->hotel_amenities) > 0) {
                $query->whereHas('hotelamenity', function ($query) use ($request) {
                    $query->whereIn('amenities_id', explode(', ', $request->hotel_amenities));
                });
            }
        })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_country_id) > 0) {
                    $query->where('hotels.hotel_country', '=', $request->requested_country_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_city_id) > 0) {
                    $query->where('hotels.hotel_city', '=', $request->requested_city_id);
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->star) > 0) {
                    $query->where('hotels.category', '<=', $request->star);
                }
            })
            ->count();
    }
}
