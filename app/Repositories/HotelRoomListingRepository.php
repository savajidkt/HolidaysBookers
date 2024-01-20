<?php

namespace App\Repositories;

use App\Models\Complimentary;
use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomChildPrice;
use App\Models\OfflineRoomPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelRoomListingRepository {

    public function hotelRoomLists(array $param) {
        $searchGuestArr = getSearchCookies('searchGuestArr');
        $roomCount = getSearchCookies('searchGuestRoomCount');
        $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
        $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
        $adults = getLowestGuest();
        if (!$searchGuestArr) {
            return false;
        }

        $hotelsDetails = OfflineHotel::find($param['filterObjParamHotelID'])->toArray();
        $hotel = OfflineHotel::find($param['filterObjParamHotelID']);
        if (!$hotelsDetails) {
            return false;
        }

        $hotelArr['hotel'] = $hotelsDetails;

        $hotelRooms = OfflineRoom::with(['price'])->where(function ($query) use ($startDate, $endDate) {
                            if (strlen(getSearchCookies('search_from')) > 0 && strlen(getSearchCookies('search_to')) > 0) {
                                $query->whereHas('price', function ($query) use ($startDate, $endDate) {
                                    $query->whereDate('from_date', '<=', $startDate);
                                    $query->whereDate('to_date', '>=', $endDate);
                                    $query->groupBy('meal_plan_id');
                                    //$query->orderBy('price_p_n_twin_sharing','ASC');
                                });
                            }
                        })->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE)
                        ->where('hotel_id', $param['filterObjParamHotelID'])->get();
        $hotelRooms->loadMissing('price');

        $roomListingArray = [];
        $roomPriceListingArray = [];
        $tempRoomArray = [];
        $tempSearRoomArray = [];
        $room_key=0;
        foreach ($searchGuestArr as $key=>$searchRoom) {
            $totalAdChild = $searchRoom->adult + $searchRoom->child;
            $rooms = $hotel->rooms()->where('occ_sleepsmax', '>=', $totalAdChild)->where('status', OfflineRoom::ACTIVE)->get();
            
            $age=[];
           foreach($searchRoom->childAge as $child){
                $age[] = $child->age;
           }
            if ($rooms) {
                foreach ($rooms as $roomkey => $srRoom) {
                    $roomPriceListingArray = [];
                    $roomTempArray = [];
                    $tempSearRoomArray[$srRoom->id] = $searchRoom;
                    $roomListingArray[$room_key]['hotel_id'] = $srRoom->hotel_id;
                    $roomListingArray[$room_key]['room_id'] = $srRoom->id;
                    $roomListingArray[$room_key]['min_nights'] = $srRoom->min_nights;
                    $roomListingArray[$room_key]['room_type'] = $srRoom->roomtype->room_type;
                    $room_title_with_child='';
                    if($searchRoom->adult){
                        $room_title_with_child ='for '.$searchRoom->adult.' adults';
                    }
                    if($searchRoom->child){
                        $room_title_with_child .=', '.$searchRoom->child.' children - '.implode(',',$age).' years old';
                    }

                    $roomListingArray[$room_key]['room_title_with_child'] = $room_title_with_child; 
                    $roomListingArray[$room_key]['room_adults'] = $searchRoom->adult;
                    $roomListingArray[$room_key]['room_childs'] = $searchRoom->child;
                    $roomListingArray[$room_key]['room_child_age'] = $searchRoom->childAge;
                    $roomTempArray['room'] = $srRoom->toArray();
                    $roomTempArray['room']['room_amenities'] = $srRoom->roomamenity->toArray();
                    $roomTempArray['room']['room_mealplans'] = isset($srRoom->mealplan) ? $srRoom->mealplan->toArray() : [];
                    $roomTempArray['room']['room_freebies'] = $srRoom->roomfreebies->toArray();
                    $roomTempArray['room']['room_images'] = $srRoom->images->toArray();
                    $roomTempArray['room']['room_types'] = $srRoom->roomtype->toArray();
                    $roomTempArray['room']['room_child'] = [];
                    $roomTempArray['room']['room_facilities'] = [];

                    $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                    $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));

                    $roomTemArr = [];
                    $normalDays = 0;
                    $promoDays = 0;
                    $blackDays = 0;
                    $normalDaysPrice = 0;
                    $promoDaysPrice = 0;
                    $blackDaysPrice = 0;
                    $normalChildPrice = 0;
                    $balckChildPrice = 0;
                    $promoChildPrice = 0;
                    $blackTotalDays = 0;
                    $promoTotalDays = 0;
                    $filterObjParamChild = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
                    $tempRoomArray = [];
                    //$tempSearRoomArray = [];

                    foreach ($srRoom->price as $pkey => $price) {
                        //BLACKOUTSALE
                        $surCharges = getDateWiseSurcharge($hotel, $startDate, $endDate);
                        if ($surCharges) {
                            foreach ($surCharges as $key => $surcharge) {
                                $blackDays = $surcharge['days'];
                                $blackTotalDays = $blackTotalDays + $blackDays;
                                $blackDaysPrice = $blackDaysPrice + $surcharge['total_amount'];
                                $adults = $tempSearRoomArray[$srRoom->id]->adult;
                                //$adults = 2;
                                if ($adults > 2) {
                                    $extraAdult = $adults - 2;
                                    $surchargePrice = $price->price_p_n_twin_sharing + ($price->price_p_n_extra_adult * $extraAdult);
                                } else {
                                    $surchargePrice = $price->price_p_n_twin_sharing;
                                }
                                $blackDaysPrice = $blackDaysPrice + ($surchargePrice * $blackDays);

                                if ($filterObjParamChild > 0) {
                                    $balckChildPrice = getChildrenPrice($searchGuestArr, $price);
                                }
                                $blackDaysPrice = $blackDaysPrice + ($balckChildPrice * $blackDays);
                            }
                        }
                        //PROMOTIONAL DAYS
                        $promoCharges = getDateWisePromotional($hotel, $startDate, $endDate);
                        if ($promoCharges) {
                            foreach ($promoCharges as $key => $promocharge) {
                                $promoDays = $promocharge['days'];
                                $promoTotalDays = $promoTotalDays + $promoDays;
                                $adults = $tempSearRoomArray[$srRoom->id]->adult;
                                if ($adults > 2) {
                                    $extraAdult = $adults - 2;
                                    $promocharge['per_room'] + ($promocharge['extra_adult'] * $extraAdult);
                                } else {
                                    $promocharge['per_room'];
                                }
                                $promoDaysPrice = $promocharge['per_room'] * $promoDays;

                                if ($filterObjParamChild > 0) {
                                    $promoChildPrice = $promoChildPrice + getChildrenPromoPrice($searchGuestArr, $promocharge);
                                }
                                $promoDaysPrice = $promoDaysPrice + ($promoChildPrice * $promoDays);
                            }
                        }

                        if ($price->price_type == OfflineRoomPrice::NORMAL) {

                            $normalDays = getDateNormalPrice($startDate, $endDate, $promoTotalDays, $blackTotalDays);
                            $adults = $tempSearRoomArray[$srRoom->id]->adult;
                            if ($adults > 2) {
                                $extraAdult = $adults - 2;
                                $normalPrice = $price->price_p_n_twin_sharing + ($price->price_p_n_extra_adult * $extraAdult);
                            } else {
                                $normalPrice = $price->price_p_n_twin_sharing;
                            }
                            $normalDaysPrice = $normalPrice * $normalDays;
                            if ($filterObjParamChild > 0) {
                                $normalChildPrice = getChildrenPrice($searchGuestArr, $price);
                            }
                            $normalDaysPrice = $normalDaysPrice + ($normalChildPrice * $normalDays);
                        }

                        $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice);
                        //$total_priceArr = getAgentRoomPrice($finalRoomPrice, $hotelArr);
                    }

                    //$normalDays = ($normalDays - ($promoDays + $blackDays));
                    //$normalDaysPrice = $normalDaysPrice * $normalDays;
                   // $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice + $balckChildPrice);

                    $GroupByPrices = OfflineRoomPrice::where('id', $price->id)->groupBy('meal_plan_id')->get();
                    $Complimentary = Complimentary::where('hotel_id',$srRoom->hotel_id)->get();
                    $complimentaryPrice = 0;
                    $totalDays = getDateDiffDays($startDate, $endDate);

                    $currency_Code = "";
                    foreach ($GroupByPrices as $pkey => $price) {
                        if( strlen($currency_Code) == 0 ){
                            $currency_Code = $price->currency->code;
                        }
                        $total_priceArr = getAgentRoomPrice($finalRoomPrice, $hotelArr, $currency_Code);
                        $roomPriceListingArray[$pkey]['price_id'] = $price->id;
                        $roomPriceListingArray[$pkey]['meal_plan'] = $price->mealplan->name;
                        $roomPriceListingArray[$pkey]['meal_plan_short'] = getCharacterOfString($price->mealplan->name);
                        $roomPriceListingArray[$pkey]['currency'] = $price->currency->code;
                        $roomPriceListingArray[$pkey]['market_price'] = currencyExchange($price->market_price, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);                        
                        $roomPriceListingArray[$pkey]['price_p_n_single_adult'] = currencyExchange($finalRoomPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);                        
                        $roomPriceListingArray[$pkey]['price_p_n_cwb'] = currencyExchange($price->price_p_n_cwb, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                        $roomPriceListingArray[$pkey]['price_p_n_cwb'] = currencyExchange($price->price_p_n_cwb, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                        $roomPriceListingArray[$pkey]['price_p_n_cob'] = currencyExchange($price->price_p_n_cob, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                        $roomPriceListingArray[$pkey]['price_p_n_ccob'] = currencyExchange($price->price_p_n_ccob, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                        $roomPriceListingArray[$pkey]['normal_day'] = (int) $normalDays; // + $price->price_p_n_cwb
                        $roomPriceListingArray[$pkey]['normal_price'] = currencyExchange($normalDaysPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code); // + $price->price_p_n_cwb
                        $roomPriceListingArray[$pkey]['child_price'] = currencyExchange($balckChildPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code); // + $price->price_p_n_cwb
                        $roomPriceListingArray[$pkey]['totalDays'] = $totalDays;
                        $roomPriceListingArray[$pkey]['originAmount'] = numberFormat(($total_priceArr['originAmount']) ? $total_priceArr['originAmount'] : 0);                        
                        $roomPriceListingArray[$pkey]['adminproductMarkupAmount'] = numberFormat(($total_priceArr['productMarkupAmount']) ? $total_priceArr['productMarkupAmount'] : 0);
                        $roomPriceListingArray[$pkey]['adminagentMarkupAmount'] = numberFormat(($total_priceArr['agentMarkupAmount']) ? $total_priceArr['agentMarkupAmount'] : 0);
                        $roomPriceListingArray[$pkey]['agentMarkupAmount'] = numberFormat(($total_priceArr['agentGlobalMarkupAmount']) ? $total_priceArr['agentGlobalMarkupAmount'] : 0);
                        $roomPriceListingArray[$pkey]['finalAmount'] = numberFormat(($total_priceArr['finalAmount']) ? $total_priceArr['finalAmount'] : 0);
                    }

                    if( $Complimentary ){
                        foreach ($Complimentary as $ckey => $cvalue) {
                            $complimentaryPrice =  $cvalue->complimentary_price;
                             $complimentaryPriceWithDays = $complimentaryPrice * $totalDays;
                            if( $complimentaryPriceWithDays > 0 ){
                                $finalRoomPrice = $finalRoomPrice + $complimentaryPriceWithDays;
                            }
                            if(strlen($currency_Code) == 0 ){
                                $currency_Code = $price->currency->code;
                            }
                            $total_priceArr = getAgentRoomPrice($finalRoomPrice, $hotelArr, $currency_Code);
                            $roomCompliPriceListing['price_id'] = $price->id;
                            $roomCompliPriceListing['meal_plan'] = $cvalue->mealplans->name;
                            $roomCompliPriceListing['meal_plan_short'] = getCharacterOfString($cvalue->mealplans->name);
                            $roomCompliPriceListing['currency'] = $price->currency->code;
                            $roomCompliPriceListing['market_price'] = currencyExchange($price->market_price, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);                        
                            $roomCompliPriceListing['price_p_n_single_adult'] = currencyExchange($finalRoomPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);                        
                            $roomCompliPriceListing['price_p_n_cwb'] = currencyExchange($price->price_p_n_cwb, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                            $roomCompliPriceListing['price_p_n_cwb'] = currencyExchange($price->price_p_n_cwb, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                            $roomCompliPriceListing['price_p_n_cob'] = currencyExchange($price->price_p_n_cob, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                            $roomCompliPriceListing['price_p_n_ccob'] = currencyExchange($price->price_p_n_ccob, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                            $roomCompliPriceListing['normal_day'] = (int) $normalDays; // + $price->price_p_n_cwb
                            $roomCompliPriceListing['normal_price'] = currencyExchange($normalDaysPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code); // + $price->price_p_n_cwb
                            $roomCompliPriceListing['child_price'] = currencyExchange($balckChildPrice, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code); // + $price->price_p_n_cwb
                            $roomCompliPriceListing['complimentaryPrice'] = currencyExchange(($complimentaryPriceWithDays) ? $complimentaryPriceWithDays : 0, getcurrencyExchangeRate($currency_Code), getcurrencyExchangeDefualtRate(), $currency_Code);
                            $roomCompliPriceListing['totalDays'] = $totalDays;
                            $roomCompliPriceListing['originAmount'] = numberFormat(($total_priceArr['originAmount']) ? $total_priceArr['originAmount'] : 0);                        
                            $roomCompliPriceListing['adminproductMarkupAmount'] = numberFormat(($total_priceArr['productMarkupAmount']) ? $total_priceArr['productMarkupAmount'] : 0);
                            $roomCompliPriceListing['adminagentMarkupAmount'] = numberFormat(($total_priceArr['agentMarkupAmount']) ? $total_priceArr['agentMarkupAmount'] : 0);
                            $roomCompliPriceListing['agentMarkupAmount'] = numberFormat(($total_priceArr['agentGlobalMarkupAmount']) ? $total_priceArr['agentGlobalMarkupAmount'] : 0);
                            $roomCompliPriceListing['finalAmount'] = numberFormat(($total_priceArr['finalAmount']) ? $total_priceArr['finalAmount'] : 0);
                           array_push($roomPriceListingArray,$roomCompliPriceListing);
                        }
                    }
                    
                     usort($roomPriceListingArray, function ($item1, $item2) {
                         return $item1['finalAmount'] <=> $item2['finalAmount'];
                     });

                    $roomListingArray[$room_key]['room_facilities'] = [];
                    $roomListingArray[$room_key]['room_price'] = $roomPriceListingArray;
                    $room_key ++;
                }
            }
        }
        usort($roomListingArray, function ($item1, $item2) {
            return $item1['room_price'][0]['finalAmount'] <=> $item2['room_price'][0]['finalAmount'];
        });
        //dd($roomListingArray);
        return $roomListingArray;
    }

    public function hotelRelated(array $hotelsDetails) {
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
