<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\Customer;
use App\Models\OfflineRoom;
use Illuminate\Support\Str;
use App\Models\OfflineHotel;
use Illuminate\Http\Request;
use App\Models\OfflineRoomPrice;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Hash;
use App\Models\OfflineRoomChildPrice;
use Illuminate\Support\Facades\Storage;
use App\Models\OfflineRoomFacilitiesPrice;
use App\Models\OfflineRoomCancelationPolicies;

class OfflineRoomRepository
{

    public function create(Request $request, array $data): OfflineRoom
    {
        /**
         * Inser Room Data
         */


        if (is_array($data['rooms']) && count($data['rooms']) > 0) {
            $RoomArr = [
                'hotel_id'    => $data['hotel_id'],
            ];
            foreach ($data['rooms'] as $key => $value) {

                $RoomArr['room_type_id'] = $value['room_type'];
                // $RoomArr['meal_plan_id'] = $value['meal_plan'];
                $RoomArr['occ_sleepsmax'] = $value['occ_sleepsmax'];
                $RoomArr['occ_num_beds'] = $value['occ_num_beds'];
                $RoomArr['occ_max_adults'] = $value['occ_max_adults'];
                $RoomArr['occ_max_child_w_max_adults'] = $value['occ_max_child_w_max_adults'];
                $RoomArr['occ_max_child_wo_extra_bed'] = $value['occ_max_child_wo_extra_bed'];
                $RoomArr['type'] = 1;
                $RoomArr['status'] = $value['status'];
                $offlineRoom =  OfflineRoom::create($RoomArr);
                $offlineRoom->roomamenity()->attach($value['room_amenities']);
                if (isset($value['room_freebies'])) {
                    $offlineRoom->roomfreebies()->attach($value['room_freebies']);
                }


                /**
                 * Room Image Add
                 */

                if ($request->room_image) {
                    foreach ($request->room_image[$key] as $files) {
                        $Filename = time() . Str::random(8) . '.' . $files->getClientOriginalExtension();
                        $files->move(storage_path('app/upload/') . "/Hotel/" . $data['hotel_id'] . "/Room/" . $offlineRoom->id . "/", $Filename);
                    }
                    $offlineRoom->update(['room_image' => $Filename]);
                }

                /**
                 * Room Gallery Add
                 */

                $images = [];
                if ($request->room_gallery_image) {
                    foreach ($request->room_gallery_image[$key] as $file) {
                        $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                        $file->move(storage_path('app/upload/') . "/Hotel/" . $data['hotel_id'] . "/Room/" . $offlineRoom->id . "/Gallery/", $fileName);
                        $images[] = ['images' => $fileName];
                    }
                }
                $offlineRoom->images()->createMany($images);
            }
        }
        return $offlineRoom;
    }


    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return OfflineRoom
     */
    public function update(Request $request, array $data, OfflineRoom $offlineroom): OfflineRoom
    {


        $RoomArr['room_type_id'] = $data['room_type'];
        //$RoomArr['meal_plan_id'] = $data['meal_plan'];
        $RoomArr['occ_sleepsmax'] = $data['occ_sleepsmax'];
        $RoomArr['occ_num_beds'] = $data['occ_num_beds'];
        $RoomArr['occ_max_adults'] = $data['occ_max_adults'];
        $RoomArr['occ_max_child_w_max_adults'] = $data['occ_max_child_w_max_adults'];
        $RoomArr['occ_max_child_wo_extra_bed'] = $data['occ_max_child_wo_extra_bed'];
        $RoomArr['status'] = $data['status'];

        $offlineroom->update($RoomArr);

        if (isset($data['room_amenities'])) {
            $offlineroom->roomamenity()->detach();
            $offlineroom->roomamenity()->attach($data['room_amenities']);
        }

        if (isset($data['room_freebies'])) {
            $offlineroom->roomfreebies()->detach();
            $offlineroom->roomfreebies()->attach($data['room_freebies']);
        }

        /**
         * Room Image Add
         */

        if ($request->room_image) {
            foreach ($request->room_image as $files) {
                $Filename = time() . Str::random(8) . '.' . $files->getClientOriginalExtension();
                $files->move(storage_path('app/upload/') . "/Hotel/" . $offlineroom->hotel_id . "/Room/" . $offlineroom->id . "/", $Filename);
            }
            $offlineroom->update(['room_image' => $Filename]);
        }

        /**
         * Room Gallery Add
         */

        $images = [];
        if ($request->room_gallery_image) {
            foreach ($request->room_gallery_image as $file) {

                $fileName = time() . Str::random(8) . '.' . $file->getClientOriginalExtension();
                $file->move(storage_path('app/upload/') . "/Hotel/" . $offlineroom->hotel_id . "/Room/" . $offlineroom->id . "/Gallery/", $fileName);
                $images[] = ['images' => $fileName];
            }
        }
        $offlineroom->images()->createMany($images);
        return $offlineroom;
    }


    /**
     * Method delete
     *
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return bool
     */
    public function delete(OfflineRoom $offlineroom): bool
    {
        if ($offlineroom->delete()) {
            return true;
        }

        throw new Exception('Offline Room delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, OfflineRoom $offlineroom): bool
    {
        $offlineroom->status = !$input['status'];
        return $offlineroom->save();
    }

    /**
     * Method createPrice
     *
     * @param array $data [explicite description]
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return OfflineRoom
     */
    public function createPrice(array $data, OfflineRoom $offlineroom): OfflineRoom
    {

        $TravelDate = explode(' to ', $data['start_date']);
        $BookingDate = explode(' to ', $data['booking_start_date']);
        /**
         * Inser Room Price Data
         */
        $RoomPriceArr = [
            'room_id'     => $offlineroom->id,
            'meal_plan_id'     => $data['meal_plan'],
            'from_date'     => dateFormatNewMethod(isset($TravelDate[0]) ? $TravelDate[0] : ''),
            'to_date'     => dateFormatNewMethod(isset($TravelDate[1]) ? $TravelDate[1] : ''),
            'booking_start_date'     => dateFormatNewMethod(isset($BookingDate[0]) ? $BookingDate[0] : ''),
            'booking_end_date'     => dateFormatNewMethod(isset($BookingDate[1]) ? $BookingDate[1] : ''),
            'currency_id'     => $data['currency_id'],
            'cutoff_price'     => $data['cutoff_price'],
            'min_nights'     => $data['min_nights'],
            'min_overall_nights'     => $data['min_overall_nights'],
            'price_p_n_single_adult'     => $data['price_p_n_single_adult'],
            'price_p_n_twin_sharing'     => $data['price_p_n_twin_sharing'],
            'price_p_n_extra_adult'     => $data['price_p_n_extra_adult'],
            'price_p_n_cwb'     => $data['price_p_n_cwb'],
            'price_p_n_cob'     => $data['price_p_n_cob'],
            'price_p_n_cob_5_12'     => $data['price_p_n_cob_5_12'],
            'price_p_n_cob_13_18'     => $data['price_p_n_cob_13_18'],
            'price_p_n_ccob'     => isset($data['price_p_n_ccob']) ? $data['price_p_n_ccob'] : 0,
            'tax_p_n_single_adult'     => $data['tax_p_n_single_adult'],
            'tax_p_n_twin_sharing'     => $data['tax_p_n_twin_sharing'],
            'tax_p_n_extra_adult'     => $data['tax_p_n_extra_adult'],
            'tax_p_n_cwb'     => $data['tax_p_n_cwb'],
            'tax_p_n_cob'     => $data['tax_p_n_cob'],
            'tax_p_n_cob_5_12'     => $data['tax_p_n_cob_5_12'],
            'tax_p_n_cob_13_18'     => $data['tax_p_n_cob_13_18'],
            'tax_p_n_ccob'     => isset($data['tax_p_n_ccob']) ? $data['tax_p_n_ccob']: 0,        
            'market_price'     => $data['market_price'],
            'promo_code'     => $data['promo_code'] ?? '',
            'rate_offered'     => $data['rate_offered'],
            'commission'     => $data['commission'],
            'cancelation_policy'     => $data['cancelation_policy'],
            'early_birdoffer'     => isset($data['early_birdoffer']) ? 1 : 0,
            'pre_purchase_rate'     => isset($data['pre_purchase_rate']) ? 1 : 0,
            'rates_valid_for_package_only'     => isset($data['rates_valid_for_package_only']) ? 1 : 0,
            'days_monday'     => isset($data['days_monday']) ? 1 : 0,
            'days_tuesday'     => isset($data['days_tuesday']) ? 1 : 0,
            'days_wednesday'     => isset($data['days_wednesday']) ? 1 : 0,
            'days_thursday'     => isset($data['days_thursday']) ? 1 : 0,
            'days_friday'     => isset($data['days_friday']) ? 1 : 0,
            'days_saturday'     => isset($data['days_saturday']) ? 1 : 0,
            'days_sunday'     => isset($data['days_sunday']) ? 1 : 0,
            'price_type'     => $data['price_type']
        ];

        $offlineRoomPrice =  OfflineRoomPrice::create($RoomPriceArr);       
        
        if ($data['cancelation_policy'] != "non_refundeble") {
            if (isset($data['cancelation-policies']) && is_array($data['cancelation-policies']) && count($data['cancelation-policies']) > 0) {
                foreach ($data['cancelation-policies'] as $key => $value) {
                    $cancelationArr['room_id'] = $offlineroom->id;
                    $cancelationArr['price_id'] = $offlineRoomPrice->id;
                    $cancelationArr['before_check_in_days'] = $value['before_check_in_days'];                
                    $cancelationArr['night'] = $value['night'];
                    $cancelationArr['night_charge'] = $value['night_charge'];
                    $cancelationArr['description'] = $value['description'];
                    OfflineRoomCancelationPolicies::create($cancelationArr);
                }
            }
        }
        return $offlineroom;
    }

    /**
     * Method updatePrice
     *
     * @param array $data [explicite description]
     * @param OfflineRoomPrice $offlineroomprice [explicite description]
     *
     * @return OfflineRoomPrice
     */
    public function updatePrice(array $data, OfflineRoomPrice $offlineroomprice): OfflineRoomPrice
    {


        $TravelDate = explode(' to ', $data['start_date']);
        $BookingDate = explode(' to ', $data['booking_start_date']);

        $RoomPriceArr = [
            'meal_plan_id'     => $data['meal_plan'],
            'from_date'     => dateFormatNewMethod(isset($TravelDate[0]) ? $TravelDate[0] : ''),
            'to_date'     => dateFormatNewMethod(isset($TravelDate[1]) ? $TravelDate[1] : ''),
            'booking_start_date'     => dateFormatNewMethod(isset($BookingDate[0]) ? $BookingDate[0] : ''),
            'booking_end_date'     => dateFormatNewMethod(isset($BookingDate[1]) ? $BookingDate[1] : ''),
            'currency_id'     => $data['currency_id'],
            'cutoff_price'     => $data['cutoff_price'],
            'min_nights'     => $data['min_nights'],
            'min_overall_nights'     => $data['min_overall_nights'],
            'price_p_n_single_adult'     => $data['price_p_n_single_adult'],
            'price_p_n_twin_sharing'     => $data['price_p_n_twin_sharing'],
            'price_p_n_extra_adult'     => $data['price_p_n_extra_adult'],
            'price_p_n_cwb'     => $data['price_p_n_cwb'],
            'price_p_n_cob'     => $data['price_p_n_cob'],
            'price_p_n_cob_5_12'     => $data['price_p_n_cob_5_12'],
            'price_p_n_cob_13_18'     => $data['price_p_n_cob_13_18'],
            'price_p_n_ccob'     => isset($data['price_p_n_ccob']) ? $data['price_p_n_ccob'] : 0,
            'tax_p_n_single_adult'     => $data['tax_p_n_single_adult'],
            'tax_p_n_twin_sharing'     => $data['tax_p_n_twin_sharing'],
            'tax_p_n_extra_adult'     => $data['tax_p_n_extra_adult'],
            'tax_p_n_cwb'     => $data['tax_p_n_cwb'],
            'tax_p_n_cob'     => $data['tax_p_n_cob'],
            'tax_p_n_cob_5_12'     => $data['tax_p_n_cob_5_12'],
            'tax_p_n_cob_13_18'     => $data['tax_p_n_cob_13_18'],
            'tax_p_n_ccob'     => isset($data['tax_p_n_ccob']) ? $data['tax_p_n_ccob']: 0,            
            'market_price'     => $data['market_price'],
            'promo_code'     => $data['promo_code'] ?? '',
            'rate_offered'     => $data['rate_offered'],
            'commission'     => $data['commission'],
            'days_monday'     => isset($data['days_monday']) ? 1 : 0,
            'days_tuesday'     => isset($data['days_tuesday']) ? 1 : 0,
            'days_wednesday'     => isset($data['days_wednesday']) ? 1 : 0,
            'days_thursday'     => isset($data['days_thursday']) ? 1 : 0,
            'days_friday'     => isset($data['days_friday']) ? 1 : 0,
            'days_saturday'     => isset($data['days_saturday']) ? 1 : 0,
            'days_sunday'     => isset($data['days_sunday']) ? 1 : 0,
            'price_type'     => $data['price_type']
        ];
        $offlineroomprice->update($RoomPriceArr);        

        
        if ($data['cancelation_policy'] != "non_refundeble") {
            if (is_array($data['cancelation-policies']) && count($data['cancelation-policies']) > 0) {
                OfflineRoomCancelationPolicies::where('room_id', $offlineroomprice->room_id)->where('price_id', $offlineroomprice->id)->delete();
                foreach ($data['cancelation-policies'] as $key => $value) {
                    $cancelationArr['before_check_in_days'] = $value['before_check_in_days'];                
                    $cancelationArr['night'] = $value['night'];
                    $cancelationArr['night_charge'] = $value['night_charge'];
                    $cancelationArr['description'] = $value['description'];
                    $cancelationArr['room_id'] = $offlineroomprice->room_id;
                    $cancelationArr['price_id'] = $offlineroomprice->id;
                    OfflineRoomCancelationPolicies::create($cancelationArr);
                }
            }        
        } else {
            OfflineRoomCancelationPolicies::where('room_id', $offlineroomprice->room_id)->where('price_id', $offlineroomprice->id)->delete(); 
        }      
        return $offlineroomprice;
    }

    /**
     * Method deletePrice
     *
     * @param OfflineRoomPrice $offlineroomprice [explicite description]
     *
     * @return bool
     */
    public function deletePrice(OfflineRoomPrice $offlineroomprice): bool
    {
        if ($offlineroomprice->delete()) {
            return true;
        }

        throw new Exception('Offline Room Price deleted failed.');
    }


    public function deleteChild(OfflineRoomChildPrice $offlineroomchildprice): bool
    {
        if ($offlineroomchildprice->forceDelete()) {
            return true;
        }

        throw new Exception('Offline Room child delete failed.');
    }
}
