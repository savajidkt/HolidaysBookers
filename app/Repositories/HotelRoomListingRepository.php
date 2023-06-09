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
        $searchGuestArr = getSearchCookies('searchGuestArr');       
       
        if (!$searchGuestArr) {                     
            return false;        
        }

        $hotelsDetails = OfflineHotel::find($param['filterObjParamHotelID'])->toArray();
        if (!$hotelsDetails) {
            return false; 
        }

        $hotelArr['hotel'] = $hotelsDetails;

        
        $tempRoomId = [];
        foreach ($searchGuestArr as $key => $room) {
            $adults = 0;
            $adults = $room->adult + $room->child;
            $hotelRooms = OfflineRoom::with(['price'])->where(function ($query) use ($param) {
                if (strlen(getSearchCookies('search_from')) > 0 && strlen(getSearchCookies('search_to')) > 0) {
                    $query->whereHas('price', function ($query) use ($param) {
                        $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                        $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                        $query->whereDate('from_date', '<=', $startDate);
                        $query->whereDate('to_date', '>=', $endDate);
                        $query->groupBy('meal_plan_id');
                    });
                    $query->whereDoesntHave('price', function ($query) use ($param) {
                        $query->where('price_type', OfflineRoomPrice::STOPSALE);
                    });
                }
            })->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $param['filterObjParamHotelID'])->get();
            $hotelRooms->loadMissing('price');
        }
        
       
        $roomListingArray = [];
        $roomPriceListingArray = [];
        foreach ($hotelRooms as $key => $roomPrice) {
         // dd($roomPrice->mealplan->toArray());
            $roomPriceListingArray = [];
            $roomTempArray = [];
            $roomListingArray[$key]['hotel_id'] = $roomPrice->hotel_id;
            $roomListingArray[$key]['room_id'] = $roomPrice->id;
            $roomListingArray[$key]['min_nights'] = $roomPrice->min_nights;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomTempArray['room'] = $roomPrice->toArray();
            $roomTempArray['room']['room_amenities'] = $roomPrice->roomamenity->toArray();
            $roomTempArray['room']['room_mealplans'] = isset($roomPrice->mealplan) ? $roomPrice->mealplan->toArray() : [];
            $roomTempArray['room']['room_freebies'] = $roomPrice->roomfreebies->toArray();
            $roomTempArray['room']['room_images'] = $roomPrice->images->toArray();
            $roomTempArray['room']['room_types'] = $roomPrice->roomtype->toArray();
            $roomTempArray['room']['room_child'] = [];
            $roomTempArray['room']['room_facilities'] = [];

            $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
            $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));

            $normalDays = 0;
            $promoDays = 0;
            $blackDays = 0;
            $normalDaysPrice = 0;
            $promoDaysPrice = 0;
            $blackDaysPrice = 0;
            $childPrice = 0;
            foreach ($roomPrice->price as $pkey => $price) {
                
                $filterObjParamChild = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
                if ($price->price_type == OfflineRoomPrice::NORMAL) {
                    $normalDays = $normalDays + dateDiffInDays($startDate, $endDate);
                    $normalDaysPrice = $price->price_p_n_single_adult;
                    if ($filterObjParamChild > 0) {
                        $childPrice = getChildrenPrice($searchGuestArr, $price);
                    }
                }
                if ($price->price_type == OfflineRoomPrice::PROMOTIONAL) {
                    $promoDays = $promoDays + dateDiffInDays($price->from_date, $price->to_date);
                    $promoDaysPrice = $price->price_p_n_single_adult * $promoDays;
                    if ($filterObjParamChild > 0) {
                        $childPrice = getChildrenPrice($searchGuestArr, $price);
                    }
                }
                if ($price->price_type == OfflineRoomPrice::BLACKOUTSALE) {
                    $blackDays = $blackDays + dateDiffInDays($price->from_date, $price->to_date);
                    $blackDaysPrice = $price->price_p_n_single_adult * $blackDays;
                    if ($filterObjParamChild > 0) {
                        $childPrice = getChildrenPrice($searchGuestArr, $price);
                    }
                }
            }      
            
            $normalDays = ($normalDays - ($promoDays + $blackDays));
            $normalDaysPrice = $normalDaysPrice * $normalDays;
            $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice + $childPrice);
            $GroupByPrices = OfflineRoomPrice::where('id', $price->id)->groupBy('meal_plan_id')->get();
            
            foreach ($GroupByPrices as $pkey => $price) {
                $total_priceArr = getAgentRoomPrice($finalRoomPrice, $hotelArr);
                $roomPriceListingArray[$pkey]['price_id'] = $price->id;
                $roomPriceListingArray[$pkey]['meal_plan'] = $price->mealplan->name;
                $roomPriceListingArray[$pkey]['meal_plan_short'] = getCharacterOfString($price->mealplan->name);
                $roomPriceListingArray[$pkey]['currency'] = $price->currency->code;
                $roomPriceListingArray[$pkey]['market_price'] = numberFormat($price->market_price);
                $roomPriceListingArray[$pkey]['price_p_n_single_adult'] = numberFormat($finalRoomPrice);
                $roomPriceListingArray[$pkey]['price_p_n_cwb'] = numberFormat($price->price_p_n_cwb);
                $roomPriceListingArray[$pkey]['price_p_n_cob'] = numberFormat($price->price_p_n_cob);
                $roomPriceListingArray[$pkey]['price_p_n_ccob'] = numberFormat($price->price_p_n_ccob);
                $roomPriceListingArray[$pkey]['normal_day'] = (int) $normalDays; // + $price->price_p_n_cwb
                $roomPriceListingArray[$pkey]['normal_price'] = numberFormat($normalDaysPrice); // + $price->price_p_n_cwb
                $roomPriceListingArray[$pkey]['child_price'] = numberFormat($childPrice); // + $price->price_p_n_cwb
                $roomPriceListingArray[$pkey]['originAmount'] = numberFormat(($total_priceArr['originAmount']) ? $total_priceArr['originAmount'] : 0);
                $roomPriceListingArray[$pkey]['adminproductMarkupAmount'] = numberFormat(($total_priceArr['productMarkupAmount']) ? $total_priceArr['productMarkupAmount'] : 0);
                $roomPriceListingArray[$pkey]['adminagentMarkupAmount'] = numberFormat(($total_priceArr['agentMarkupAmount']) ? $total_priceArr['agentMarkupAmount'] : 0);
                $roomPriceListingArray[$pkey]['agentMarkupAmount'] = numberFormat(($total_priceArr['agentGlobalMarkupAmount']) ? $total_priceArr['agentGlobalMarkupAmount'] : 0);
                $roomPriceListingArray[$pkey]['finalAmount'] = numberFormat(($total_priceArr['finalAmount']) ? $total_priceArr['finalAmount'] : 0);
            }
            
            usort($roomPriceListingArray, function ($item1, $item2) {
                return $item1['finalAmount'] <=> $item2['finalAmount'];
            });
          
            $roomListingArray[$key]['room_facilities'] = [];
            $roomListingArray[$key]['room_price'] = $roomPriceListingArray;
            //$roomListingArray[$key]['room_data_arr'] = $roomTempArray;
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
