<?php

namespace App\Repositories;

use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomChildPrice;
use App\Models\OfflineRoomPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelRoomListingRepository
{

    public function hotelRoomLists(array $param)
    {

        $adults = $param['filterObjParamAdult'];
        $hotelRooms = OfflineRoom::with(['price'])->where(function ($query) use ($param) {
            if (strlen($param['filterObjParamStartDate']) > 0 && strlen($param['filterObjParamEndDate']) > 0) {
                $query->whereHas('price', function ($query) use ($param) {
                    $startDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamStartDate']);
                    $endDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamEndDate']);                    
                    $query->whereDate('from_date','<=', $startDate);
                    $query->whereDate('to_date','>=', $endDate);
                    $query->groupBy('meal_plan_id');
                    //$query->where('price_type1','!=',OfflineRoomPrice::STOPSALE);
                });

                $query->whereDoesntHave('price', function ($query) use ($param) {
                    $query->where('price_type',OfflineRoomPrice::STOPSALE);
                });

                //$query->orderBy('price_p_n_single_adult')->orderBy('price_p_n_single_adult','asc');
            }
        })->where('occ_max_adults','>=',$adults)->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $param['filterObjParamHotelID'])->get();
        $hotelRooms->loadMissing('price');

        $roomListingArray=[];
        $roomPriceListingArray=[];
        foreach ($hotelRooms as $key => $roomPrice) {
            $roomPriceListingArray=[];
            $roomListingArray[$key]['hotel_id'] = $roomPrice->hotel_id;
            $roomListingArray[$key]['room_id'] = $roomPrice->id;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;

            $startDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamStartDate']);
            $endDate = Carbon::createFromFormat('Y-m-d', $param['filterObjParamEndDate']);
            $normalDays=0;
            $promoDays=0;
            $blackDays=0;
            $normalDaysPrice=0;
            $promoDaysPrice=0;
            $blackDaysPrice=0;
            $childPrice=0;
            foreach($roomPrice->price as $pkey=> $price){
                if($price->price_type == OfflineRoomPrice::NORMAL){
                    $normalDays = $normalDays + dateDiffInDays($startDate,$endDate);
                    $normalDaysPrice = $price->price_p_n_single_adult;
                    if($param['filterObjParamChild'] >0){
                        $childPrice = get_day_wise_children_price($price->id,$param);
                    }
                    
                }
                if($price->price_type == OfflineRoomPrice::PROMOTIONAL){
                    $promoDays = $promoDays + dateDiffInDays($price->from_date,$price->to_date);
                    $promoDaysPrice = $price->price_p_n_single_adult * $promoDays;
                    if($param['filterObjParamChild'] >0){
                        $childPrice = get_day_wise_children_price($price->id,$param);
                    }
                   
                }
                if($price->price_type == OfflineRoomPrice::BLACKOUTSALE){
                    $blackDays = $blackDays + dateDiffInDays($price->from_date,$price->to_date);
                    $blackDaysPrice = $price->price_p_n_single_adult * $blackDays;
                    if($param['filterObjParamChild'] >0){
                        $childPrice = get_day_wise_children_price($price->id,$param);
                    }
                    
                }
            }
            $normalDays = ($normalDays - ($promoDays + $blackDays));
            $normalDaysPrice = $normalDaysPrice * $normalDays;
            $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice + $childPrice);

            $GroupByPrices = OfflineRoomPrice::where('room_id',$roomPrice->id)->groupBy('meal_plan_id')->get();


            foreach($GroupByPrices as $pkey=> $price){
                $roomPriceListingArray[$pkey]['price_id'] = $price->id;
                $roomPriceListingArray[$pkey]['meal_plan'] = $price->mealplan->name;
                $roomPriceListingArray[$pkey]['meal_plan_short'] = getCharacterOfString($price->mealplan->name);

                $roomPriceListingArray[$pkey]['currency'] = $price->currency->code;
                $roomPriceListingArray[$pkey]['market_price'] = numberFormat($price->market_price);
                $roomPriceListingArray[$pkey]['price_p_n_single_adult'] = numberFormat($finalRoomPrice);
                $roomPriceListingArray[$pkey]['price_p_n_cwb'] = numberFormat($price->price_p_n_cwb);
                $roomPriceListingArray[$pkey]['price_p_n_cob'] = numberFormat($price->price_p_n_cob);
                $roomPriceListingArray[$pkey]['price_p_n_ccob'] = numberFormat($price->price_p_n_ccob);
                $roomPriceListingArray[$pkey]['total_price'] = numberFormat($finalRoomPrice); // + $price->price_p_n_cwb

            }

            usort($roomPriceListingArray, function ($item1, $item2) {
                return $item1['total_price'] <=> $item2['total_price'];
            });
            $roomListingArray[$key]['room_facilities'] = $price->facilities->toArray();
            $roomListingArray[$key]['room_price'] = $roomPriceListingArray;
            
        }
        //dd($roomListingArray);
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
