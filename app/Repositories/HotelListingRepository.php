<?php

namespace App\Repositories;

use App\Models\Complimentary;
use App\Models\OfflineHotel;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomPrice;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelListingRepository
{


    public function hotelSelectedLists($request)
    {
        $adults = getLowestGuest();
        $roomCount = getSearchCookies('searchGuestRoomCount');
        $hotels = OfflineHotel::with(['rooms.price'])->where(function ($query) use ($request) {
            if (strlen($request->hotel_amenities) > 0) {
                $query->whereHas('hotelamenity', function ($query) use ($request) {
                    $query->whereIn('amenities_id', explode(', ', $request->hotel_amenities));
                });
            }
        })->where(function ($query) use ($request) {
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
                if (strlen($request->selected_hotel_id) > 0) {
                    $query->where('hotels.id', '=', $request->selected_hotel_id);
                }
            })->whereHas('rooms',function ($query) use ($adults,$roomCount) {
                $query->select(DB::raw('*, COUNT(*) as totalroom'))->where(function($query) use ($adults) {
                    $query->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE);

                })->having('totalroom', '>=', $roomCount);
            })->whereDoesntHave('stopsale', function ($query) {
                if (strlen(getSearchCookies('search_from')) > 0 && strlen(getSearchCookies('search_to')) > 0) {
                      $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                      $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                      $query->whereBetween('stop_sale_date',[$startDate,$endDate]);
               }
            })
            ->paginate(1);
            $hotelsListingArray = [];

            foreach ($hotels as $key => $hotel) {

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
                $hotelsListingArray[$key]['hotel_amenities'] = $hotel->hotelamenity->toArray();
                $hotelsListingArray[$key]['hotel_groups'] =  $hotel->hotelgroup->toArray();
                $hotelsListingArray[$key]['hotel_images'] = $hotel->images->toArray();
                $hotelRoomArray = [];
                $hotelsDetails = OfflineHotel::find($hotel->id)->toArray();
                $hotelArr['hotel'] = $hotelsDetails;
                $tempRoomArray = [];
                $roomsIds = $hotel->rooms->pluck('id')->toArray();
    
                $searchGuestArr = getSearchCookies('searchGuestArr'); 
                
                $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
    
                    $normalDays = 0;
                    $promoDays = 0;
                    $blackDays = 0;
                    $normalDaysPrice = 0;
                    $promoDaysPrice = 0;
                    $blackDaysPrice = 0;
                    $childPrice = 0;
                    $filterObjParamChild = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
                    $tempRoomArray = [];
                    $tempSearRoomArray = [];
                   
                    foreach ($searchGuestArr as $searchRoom) {
                        $totalAdChild = $searchRoom->adult + $searchRoom->child;
                        
                        $rooms = $hotel->rooms()->where('occ_sleepsmax','>=',$totalAdChild)->where('status', OfflineRoom::ACTIVE)->get();
                        if($rooms){
                            foreach ($rooms as  $srRoom) {
                                if(!array_key_exists($srRoom->id,$tempRoomArray)){
                                        $tempRoomArray[$srRoom->id] = $srRoom;
                                        
                                }
    
                            }
                            $tempSearRoomArray[]= $searchRoom;
                        } 
                    }
    
                  
                    //Lowet Price get
                    $roomTemArr = [];
                    $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                    $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                    $normalDays = 0;
                    $promoDays = 0;
                    $blackDays = 0;
                    $normalDaysPrice = 0;
                    $promoDaysPrice = 0;
                    $blackDaysPrice = 0;
                    $normalChildPrice = 0;
                    $balckChildPrice =0;
                    $promoChildPrice =0;
                    $blackTotalDays = 0;
                    $promoTotalDays = 0;
                    $totalFinalPrice =0;
                    $i=1;
    
                    foreach ($tempRoomArray as $tepmkey => $temRoom) {
    
                     if($i <= $roomCount){
    
                        $roomPrice =$temRoom->price()->where('room_id',$temRoom->id)->orderBy('price_p_n_twin_sharing')->limit(1)->first();
                       
                        if($roomPrice){
                           
                                //BLACKOUTSALE
                                $surCharges = getDateWiseSurcharge($hotel,$startDate, $endDate);
                                if($surCharges){
                                    foreach ($surCharges as $key => $surcharge) {
                                        $blackDays =  $surcharge['days'];
                                        $blackTotalDays = $blackTotalDays + $blackDays;
                                        $blackDaysPrice =  $blackDaysPrice + $surcharge['total_amount'];
                                        $adults = $tempSearRoomArray[$i-1]->adult;
                                        if($adults > 2){
                                            $extraAdult = $adults - 2;
                                            $surchargePrice = $roomPrice->price_p_n_twin_sharing + ($roomPrice->price_p_n_extra_adult * $extraAdult);
                                        }else{
                                            $surchargePrice = $roomPrice->price_p_n_twin_sharing;
                                        }
                                        $blackDaysPrice = $blackDaysPrice + ($surchargePrice * $blackDays);
    
                                        if ($filterObjParamChild > 0) {
                                            $balckChildPrice =  getChildrenPrice($searchGuestArr, $roomPrice);
                                        }
                                        $blackDaysPrice = $blackDaysPrice + ($balckChildPrice * $blackDays);
    
                                    }
                                }
    
                                //PROMOTIONAL DAYS
                                $promoCharges = getDateWisePromotional($hotel,$startDate, $endDate);
                                if($promoCharges){
                                    foreach ($promoCharges as $key => $promocharge) {
                                        $promoDays = $promocharge['days'];
                                        $promoTotalDays = $promoTotalDays + $promoDays;
                                        $adults = $tempSearRoomArray[$i-1]->adult;
                                        if($adults > 2){
                                            $extraAdult = $adults - 2;
                                            $promocharge['per_room'] + ($promocharge['extra_adult'] * $extraAdult);
                                        }else{
                                            $promocharge['per_room'];
                                        }
                                        $promoDaysPrice = $promocharge['per_room'] * $promoDays;
    
                                        if ($filterObjParamChild > 0) {
                                            $promoChildPrice =  $promoChildPrice + getChildrenPromoPrice($searchGuestArr,$promocharge);
                                        }
                                        $promoDaysPrice = $promoDaysPrice + ($promoChildPrice * $promoDays);
                                    }
                                }
                         
                        
                           
                                $normalDays =  getDateNormalPrice($startDate, $endDate,$promoTotalDays,$blackTotalDays);
                                
                                $adults = $tempSearRoomArray[$i-1]->adult;
                               
                                if($adults > 2){
                                    $extraAdult = $adults - 2;
                                    $normalPrice = $roomPrice->price_p_n_twin_sharing + ($roomPrice->price_p_n_extra_adult * $extraAdult);
                                }else{
                                    $normalPrice = $roomPrice->price_p_n_twin_sharing;
                                }
                                $normalDaysPrice = $normalPrice * $normalDays;
                                if ($filterObjParamChild > 0) {
                                     $normalChildPrice =  getChildrenPrice($searchGuestArr, $roomPrice);
                                    
                                }
                                $normalDaysPrice = $normalDaysPrice + ($normalChildPrice * $normalDays);
    
                        
    
                            $hotelRoomArray['price_id'] = $roomPrice->id;
                            $hotelRoomArray['room_id'] = $roomPrice->room_id;
                            $hotelRoomArray['room_name'] = $roomPrice->room->roomtype->room_type;
                            $hotelRoomArray['occ_num_beds'] = $roomPrice->room->occ_num_beds;
                            $hotelRoomArray['min_nights'] = $roomPrice->min_nights;
                            $hotelRoomArray['occ_max_adults'] = $roomPrice->room->occ_max_adults;
                           
                            $hotelRoomArray['currency'] = $roomPrice->currency->code;
                        
                            $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice);
                            $totalFinalPrice = $totalFinalPrice + $finalRoomPrice; 
                            
                            
                        }
                     }
                     $i++;
                    } //temp room end
                 
                    $total_priceArr = getAgentRoomPrice($totalFinalPrice, $hotelArr, $roomPrice->currency->code);               
                    $hotelsDetails = OfflineHotel::find($hotel->id)->toArray();               
                    $hotelArr['hotel'] = $hotelsDetails;
                    $hotelRoomArray['normal_day'] = (int) $normalDays; // + $price->price_p_n_cwb
                    $hotelRoomArray['normal_price'] = numberFormat($normalDaysPrice); // + $price->price_p_n_cwb
                    $hotelRoomArray['child_price'] = 0; // + $price->price_p_n_cwb
                    $hotelRoomArray['originAmount'] = numberFormat(($total_priceArr['originAmount']) ? $total_priceArr['originAmount'] : 0);
                    $hotelRoomArray['adminproductMarkupAmount'] = numberFormat(($total_priceArr['productMarkupAmount']) ? $total_priceArr['productMarkupAmount'] : 0);
                    $hotelRoomArray['adminagentMarkupAmount'] = numberFormat(($total_priceArr['agentMarkupAmount']) ? $total_priceArr['agentMarkupAmount'] : 0);
                    $hotelRoomArray['agentMarkupAmount'] = numberFormat(($total_priceArr['agentGlobalMarkupAmount']) ? $total_priceArr['agentGlobalMarkupAmount'] : 0);
                    $hotelRoomArray['finalAmount'] = numberFormat(($total_priceArr['finalAmount']) ? $total_priceArr['finalAmount'] : 0);                
                    $hotelRoomArray['hotel_id'] = $hotel->id;
                    $hotelsListingArray[$key]['room'] = $hotelRoomArray;            
            }
        
        return ['model' => $hotels, 'data' => $hotelsListingArray];
    }

    public function hotelLists($request)
    {
        $adults = getLowestGuest();
        $roomCount = getSearchCookies('searchGuestRoomCount');
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
                if (strlen($request->star) > 0 && $request->star != "all") {
                    $query->whereIn('hotels.category', explode(', ', $request->star));
                }
            })
            ->where(function ($query) use ($request) {
                if (strlen($request->requested_selected_hotel_id) > 0 && $request->requested_selected_hotel_id != NULL && strlen($request->requested_selected_hotel_id ) > 0) {
                    $query->where('hotels.id', '!=', $request->requested_selected_hotel_id);
                }
            })->whereHas('rooms',function ($query) use ($roomCount,$adults) {
                $query->select(DB::raw('*, COUNT(*) as totalroom'))->where(function($query) use ($adults) {
                    $query->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE);
                })->having('totalroom', '>=', $roomCount);

            })->whereDoesntHave('stopsale', function ($query) {
                if (strlen(getSearchCookies('search_from')) > 0 && strlen(getSearchCookies('search_to')) > 0) {
                      $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                      $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                      $query->whereBetween('stop_sale_date',[$startDate,$endDate]);
               }
            })
            ->paginate(10);
           
          
        $hotelsListingArray = [];
        foreach ($hotels as $key => $hotel) {
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
            $hotelsListingArray[$key]['hotel_amenities'] = $hotel->hotelamenity->toArray();
            $hotelsListingArray[$key]['hotel_groups'] =  $hotel->hotelgroup->toArray();
            $hotelsListingArray[$key]['hotel_images'] = $hotel->images->toArray();
            $hotelRoomArray = [];
            $hotelsDetails = OfflineHotel::find($hotel->id)->toArray();
            $hotelArr['hotel'] = $hotelsDetails;
            $tempRoomArray = [];
            $roomsIds = $hotel->rooms->pluck('id')->toArray();

            $searchGuestArr = getSearchCookies('searchGuestArr'); 
            $roomCount = getSearchCookies('searchGuestRoomCount');
            $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
            $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));

                $normalDays = 0;
                $promoDays = 0;
                $blackDays = 0;
                $normalDaysPrice = 0;
                $promoDaysPrice = 0;
                $blackDaysPrice = 0;
                $childPrice = 0;
                $filterObjParamChild = getSearchCookies('searchGuestChildCount') ? getSearchCookies('searchGuestChildCount') : 0;
                $tempRoomArray = [];
                $tempSearRoomArray = [];
               
                foreach ($searchGuestArr as $searchRoom) {
                    $totalAdChild = $searchRoom->adult + $searchRoom->child;
                    $rooms = $hotel->rooms()->where('occ_sleepsmax','>=',$totalAdChild)->where('status', OfflineRoom::ACTIVE)->get();
                    if($rooms){
                        foreach ($rooms as  $srRoom) {
                            if(!array_key_exists($srRoom->id,$tempRoomArray)){
                                    $tempRoomArray[$srRoom->id] = $srRoom;
                                    
                            }

                        }
                        $tempSearRoomArray[]= $searchRoom;
                    } 
                }

              
                //Lowet Price get
                $roomTemArr = [];
                $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                $normalDays = 0;
                $promoDays = 0;
                $blackDays = 0;
                $normalDaysPrice = 0;
                $promoDaysPrice = 0;
                $blackDaysPrice = 0;
                $normalChildPrice = 0;
                $balckChildPrice =0;
                $promoChildPrice =0;
                $blackTotalDays = 0;
                $promoTotalDays = 0;
                $totalFinalPrice =0;
                $i=1;

                foreach ($tempRoomArray as $tepmkey => $temRoom) {

                 if($i <= $roomCount){

                    $roomPrice =$temRoom->price()->where('room_id',$temRoom->id)->orderBy('price_p_n_twin_sharing')->limit(1)->first();
                   
                    if($roomPrice){
                       
                            //BLACKOUTSALE
                            $surCharges = getDateWiseSurcharge($hotel,$startDate, $endDate);
                            if($surCharges){
                                foreach ($surCharges as $key => $surcharge) {
                                    $blackDays =  $surcharge['days'];
                                    $blackTotalDays = $blackTotalDays + $blackDays;
                                    $blackDaysPrice =  $blackDaysPrice + $surcharge['total_amount'];
                                    $adults = $tempSearRoomArray[$i-1]->adult;
                                    if($adults > 2){
                                        $extraAdult = $adults - 2;
                                        $surchargePrice = $roomPrice->price_p_n_twin_sharing + ($roomPrice->price_p_n_extra_adult * $extraAdult);
                                    }else{
                                        $surchargePrice = $roomPrice->price_p_n_twin_sharing;
                                    }
                                    $blackDaysPrice = $blackDaysPrice + ($surchargePrice * $blackDays);

                                    if ($filterObjParamChild > 0) {
                                        $balckChildPrice =  getChildrenPrice($searchGuestArr, $roomPrice);
                                    }
                                    $blackDaysPrice = $blackDaysPrice + ($balckChildPrice * $blackDays);

                                }
                            }

                            //PROMOTIONAL DAYS
                            $promoCharges = getDateWisePromotional($hotel,$startDate, $endDate);
                            if($promoCharges){
                                foreach ($promoCharges as $key => $promocharge) {
                                    $promoDays = $promocharge['days'];
                                    $promoTotalDays = $promoTotalDays + $promoDays;
                                    $adults = $tempSearRoomArray[$i-1]->adult;
                                    if($adults > 2){
                                        $extraAdult = $adults - 2;
                                        $promocharge['per_room'] + ($promocharge['extra_adult'] * $extraAdult);
                                    }else{
                                        $promocharge['per_room'];
                                    }
                                    $promoDaysPrice = $promocharge['per_room'] * $promoDays;

                                    if ($filterObjParamChild > 0) {
                                        $promoChildPrice =  $promoChildPrice + getChildrenPromoPrice($searchGuestArr,$promocharge);
                                    }
                                    $promoDaysPrice = $promoDaysPrice + ($promoChildPrice * $promoDays);
                                }
                            }
                     
                    
                       
                            $normalDays =  getDateNormalPrice($startDate, $endDate,$promoTotalDays,$blackTotalDays);
                            
                            $adults = $tempSearRoomArray[$i-1]->adult;
                           
                            if($adults > 2){
                                $extraAdult = $adults - 2;
                                $normalPrice = $roomPrice->price_p_n_twin_sharing + ($roomPrice->price_p_n_extra_adult * $extraAdult);
                            }else{
                                $normalPrice = $roomPrice->price_p_n_twin_sharing;
                            }
                            $normalDaysPrice = $normalPrice * $normalDays;
                            if ($filterObjParamChild > 0) {
                                 $normalChildPrice =  getChildrenPrice($searchGuestArr, $roomPrice);
                                
                            }
                            $normalDaysPrice = $normalDaysPrice + ($normalChildPrice * $normalDays);


                        $hotelRoomArray['price_id'] = $roomPrice->id;
                        $hotelRoomArray['room_id'] = $roomPrice->room_id;
                        $hotelRoomArray['room_name'] = $roomPrice->room->roomtype->room_type;
                        $hotelRoomArray['occ_num_beds'] = $roomPrice->room->occ_num_beds;
                        $hotelRoomArray['min_nights'] = $roomPrice->min_nights;
                        $hotelRoomArray['occ_max_adults'] = $roomPrice->room->occ_max_adults;
                        $hotelRoomArray['currency'] = $roomPrice->currency->code;
                    
                        $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice);
                        $totalFinalPrice = $totalFinalPrice + $finalRoomPrice; 
                        
                        
                    }
                 }
                 $i++;
                } //temp room end
              
                $total_priceArr = getAgentRoomPrice($totalFinalPrice, $hotelArr, $roomPrice->currency->code);               
                $hotelsDetails = OfflineHotel::find($hotel->id)->toArray();               
                $hotelArr['hotel'] = $hotelsDetails;
                $hotelRoomArray['normal_day'] = (int) $normalDays; // + $price->price_p_n_cwb
                $hotelRoomArray['normal_price'] = numberFormat($normalDaysPrice); // + $price->price_p_n_cwb
                $hotelRoomArray['child_price'] = 0; // + $price->price_p_n_cwb
                $hotelRoomArray['originAmount'] = numberFormat(($total_priceArr['originAmount']) ? $total_priceArr['originAmount'] : 0);
                $hotelRoomArray['adminproductMarkupAmount'] = numberFormat(($total_priceArr['productMarkupAmount']) ? $total_priceArr['productMarkupAmount'] : 0);
                $hotelRoomArray['adminagentMarkupAmount'] = numberFormat(($total_priceArr['agentMarkupAmount']) ? $total_priceArr['agentMarkupAmount'] : 0);
                $hotelRoomArray['agentMarkupAmount'] = numberFormat(($total_priceArr['agentGlobalMarkupAmount']) ? $total_priceArr['agentGlobalMarkupAmount'] : 0);
                $hotelRoomArray['finalAmount'] = numberFormat(($total_priceArr['finalAmount']) ? $total_priceArr['finalAmount'] : 0);                
                $hotelRoomArray['hotel_id'] = $hotel->id;
                $hotelsListingArray[$key]['room'] = $hotelRoomArray;            
        }
       
        return ['model' => $hotels, 'data' => $hotelsListingArray];
    }

    public function hotelCount($request)
    {
        $adults = getLowestGuest();
        $roomCount = getSearchCookies('searchGuestRoomCount');
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
            })->whereHas('rooms',function ($query) use ($roomCount,$adults) {
                $query->select(DB::raw('*, COUNT(*) as totalroom'))->where(function($query) use ($adults) {
                    $query->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE);
                })->having('totalroom', '>=', $roomCount);

            })->whereDoesntHave('stopsale', function ($query) {
                if (strlen(getSearchCookies('search_from')) > 0 && strlen(getSearchCookies('search_to')) > 0) {
                      $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
                      $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
                      $query->whereBetween('stop_sale_date',[$startDate,$endDate]);
               }
            })
            ->count();
    }


    public function hotelDetails($id)
    {
        $searchGuestArr = getSearchCookies('searchGuestArr');
        $roomCount = getSearchCookies('searchGuestRoomCount');
        $startDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_from'));
        $endDate = Carbon::createFromFormat('Y-m-d', getSearchCookies('search_to'));
        $adults = getLowestGuest();
        if (!$searchGuestArr) {
            return false;
        }

        $hotelsDetails = OfflineHotel::find($id)->toArray();
        $hotel = OfflineHotel::find($id);
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
                        ->where('hotel_id', $id)->get();
        $hotelRooms->loadMissing('price');
        $roomListingArray = [];
        $roomPriceListingArray = [];
        $tempRoomArray = [];
        $tempSearRoomArray = [];
        $room_key=0;
        foreach ($searchGuestArr as $searchRoom) {
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
                    $roomListingArray[$roomkey]['hotel_id'] = $srRoom->hotel_id;
                    $roomListingArray[$roomkey]['room_id'] = $srRoom->id;
                    $roomListingArray[$roomkey]['min_nights'] = $srRoom->min_nights;
                    $roomListingArray[$roomkey]['room_type'] = $srRoom->roomtype->room_type;
                    $room_title_with_child='';
                    if($searchRoom->adult){
                        $room_title_with_child ='for '.$searchRoom->adult.' adults';
                    }
                    if($searchRoom->child){
                        $room_title_with_child .=', '.$searchRoom->child.' children - '.implode(',',$age).' years old';
                    }

                    $roomListingArray[$room_key]['room_title_with_child'] = $room_title_with_child;
                    //$roomTempArray['room'] = $srRoom->toArray();
                    $roomListingArray[$roomkey]['room_amenities'] = $srRoom->roomamenity->toArray();
                    $roomListingArray[$roomkey]['room_mealplans'] = isset($srRoom->mealplan) ? $srRoom->mealplan->toArray() : [];
                    $roomListingArray[$roomkey]['room_freebies'] = $srRoom->roomfreebies->toArray();
                    $roomListingArray[$roomkey]['room_image'] = $srRoom->room_image;
                    $roomListingArray[$roomkey]['room_images'] = $srRoom->images->toArray();
                    $roomListingArray[$roomkey]['room_child'] = [];
                    $roomListingArray[$roomkey]['room_facilities'] = [];

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

                    //$roomListingArray[$roomkey]['room_facilities'] = [];
                    //$roomListingArray[$roomkey]['room_price'] = $roomPriceListingArray;
                    //$roomListingArray[$roomkey]['room_data_arr'] = $roomTempArray;
                }
            }
        }
        //dd($roomListingArray);
        usort($roomListingArray, function ($item1, $item2) {
            return $item1['room_price'][0]['finalAmount'] <=> $item2['room_price'][0]['finalAmount'];
        });
        return $roomListingArray;
    }
    public function hotelDetails_old($id)
    {

        $hotelsDetails = OfflineHotel::find($id)->toArray();
        if (!$hotelsDetails) {
            return false;
        }

        $hotelArr['hotel'] = $hotelsDetails;
        $searchGuestArr = getSearchCookies('searchGuestArr');       
       
        if (!$searchGuestArr) {                     
            return false;        
        }

        $param = [];
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
            })->where('occ_sleepsmax', '>=', $adults)->where('status', OfflineRoom::ACTIVE)->where('hotel_id', $id)->limit(2)->get();
            $hotelRooms->loadMissing('price');
        }
       
        $roomListingArray = [];
        $roomPriceListingArray = [];
        foreach ($hotelRooms as $key => $roomPrice) {
           
            $roomPriceListingArray = [];
            $roomTempArray = [];
            $roomListingArray[$key]['hotel_id'] = $roomPrice->hotel_id;
            $roomListingArray[$key]['room_id'] = $roomPrice->id;
            $roomListingArray[$key]['min_nights'] = $roomPrice->min_nights;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomListingArray[$key]['room_type'] = $roomPrice->roomtype->room_type;
            $roomTempArray['room'] = $roomPrice->toArray();
            $roomTempArray['room']['room_amenities'] = ($roomPrice->roomamenity) ? $roomPrice->roomamenity->toArray() : [];
            $roomTempArray['room']['room_mealplans'] = ($roomPrice->mealplan) ? $roomPrice->mealplan->toArray() : [];
            $roomTempArray['room']['room_freebies'] = ($roomPrice->roomfreebies) ? $roomPrice->roomfreebies->toArray() : [];            
            $roomTempArray['room']['room_images'] = ($roomPrice->images) ? $roomPrice->images->toArray() : [];            
            $roomTempArray['room']['room_types'] = ($roomPrice->roomtype) ? $roomPrice->roomtype->toArray() : [];   
            
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
               // dd( $price);
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
            //dd($childPrice);    
            $normalDays = ($normalDays - ($promoDays + $blackDays));
            $normalDaysPrice = $normalDaysPrice * $normalDays;
            $finalRoomPrice = ($normalDaysPrice + $promoDaysPrice + $blackDaysPrice + $childPrice);
            $GroupByPrices = OfflineRoomPrice::where('room_id', $roomPrice->id)->groupBy('meal_plan_id')->get();
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
            $roomListingArray[$key]['room_data_arr'] = $roomTempArray;
        }
     
        return $roomListingArray;
    }

    public function hotelDetailsArr($id)
    {
        $hotel = OfflineHotel::find($id);
        $hotelsListingArray = [];
        $hotelsListingArray['hotel'] = $hotel->toArray();
        $hotelsListingArray['hotel']['hotel_amenities'] = $hotel->hotelamenity->toArray();
        $hotelsListingArray['hotel']['hotel_freebies'] = $hotel->hotelfreebies->toArray();
        $hotelsListingArray['hotel']['hotel_groups'] =  $hotel->hotelgroup->toArray();
        $hotelsListingArray['hotel']['hotel_images'] = $hotel->images->toArray();

        $roomsIds = $hotel->rooms->pluck('id')->toArray();
        $roomPrice = OfflineRoomPrice::whereIn('room_id', $roomsIds)->orderBy('price_p_n_single_adult')->limit(1)->first();

        if ($roomPrice) {
            $hotelsListingArray['hotel']['price'] = numberFormat($roomPrice->price_p_n_single_adult, $roomPrice->currency->code);
        }


        foreach ($hotel->rooms as $key => $room) {

            $hotelRoomTempArray['room'] = $room->toArray();
            $hotelRoomTempArray['room']['amenities'] =  $room->roomamenity->toArray();
            // $hotelRoomTempArray['room']['mealplans'] =  $room->mealplan->toArray();
            $hotelRoomTempArray['room']['freebies'] =  $room->roomfreebies->toArray();
            $hotelRoomTempArray['room']['images'] =  $room->images->toArray();
            $hotelRoomTempArray['room']['types'] =  $room->roomtype->toArray();
            $hotelRoomTempArray['room']['child'] = [];
            $hotelRoomTempArray['room']['facilities'] = [];

            if ($room->price->count() > 0) {
                foreach ($room->price as $r_key => $r_room) {
                    $hotelRoomTempArray['room']['facilities'] = ''; //$r_room->facilities->toArray();
                    $roomArr = $r_room->toArray();
                    $roomArr['price'] = numberFormat($r_room->price_p_n_single_adult, $r_room->currency->code);;
                    $hotelRoomTempArray['room']['child'][] = $roomArr;
                }
            }
            $hotelsListingArray['roomDetails'][] = $hotelRoomTempArray;
        }


        return $hotelsListingArray;
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
