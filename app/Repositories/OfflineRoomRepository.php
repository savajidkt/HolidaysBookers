<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use App\Models\OfflineHotel;
use App\Models\Customer;
use App\Exceptions\GeneralException;
use App\Models\OfflineRoom;
use App\Models\OfflineRoomChildPrice;
use App\Models\OfflineRoomPrice;
use Illuminate\Support\Facades\Hash;

class OfflineRoomRepository
{

    public function create(array $data): OfflineRoom
    {
        /**
         * Inser Room Data
         */
        $RoomArr = [
            'hotel_id'    => $data['hotel_id'],
            'room_type_id'    => $data['room_type'],
            'amenities_id'    => $data['room_amenities'],
            'total_adult'    => $data['no_of_adult'],
            'total_cwb'    => $data['no_of_cwb'],
            'total_cnb'    => $data['no_of_cnb'],
            'max_pax'    => $data['max_pax'],
            'min_pax'    => $data['min_pax'],
            'type'    => 1,
            'status'    => $data['status'],
        ];

        $offlineRoom =  OfflineRoom::create($RoomArr);

        /**
         * Inser Room Price Data
         */
        $RoomPriceArr = [
            'room_id'     => $offlineRoom->id,
            'from_date'     => $data['start_date'],
            'to_date'     => $data['end_date'],
            'single_adult_price'     => $data['single_occupancy'],
            'adult_price'     => $data['double_occupancy'],
            'extra_bed_price'     => $data['extra_pax_price'],
            'price_type'     => $data['price_type']
        ];
        $offlineRoomPrice =  OfflineRoomPrice::create($RoomPriceArr);

        /**
         * Inser Room Child Price Data
         */

        $RoomChildPriceArr = [
            'room_id'     => $offlineRoom->id,
            'price_id'     => $offlineRoomPrice->id,
            'from_date'     => $data['start_date'],
            'to_date'     => $data['end_date'],
        ];

        if (is_array($data['childrens']) && count($data['childrens']) > 0) {
            foreach ($data['childrens'] as $key => $value) {
                $RoomChildPriceArr['min_age'] = $value['main_age'];
                $RoomChildPriceArr['max_age'] = $value['max_age'];
                $RoomChildPriceArr['cwb_price'] = $value['cwb_price'];
                $RoomChildPriceArr['cnb_price'] = $value['cnb_price'];
                $offlineRoomChildPrice =  OfflineRoomChildPrice::create($RoomChildPriceArr);
            }
        }
        exit;

        return $offlineRoomChildPrice;
    }

       
    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param OfflineRoom $offlineroom [explicite description]
     *
     * @return OfflineRoom
     */
    public function update(array $data, OfflineRoom $offlineroom): OfflineRoom
    {
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
        if ($offlineroom->forceDelete()) {
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
}
