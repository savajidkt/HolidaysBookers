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
                $RoomArr['meal_plan_id'] = $value['meal_plan'];
                $RoomArr['total_adult'] = $value['no_of_adult'];
                $RoomArr['total_cwb'] = $value['no_of_cwb'];
                $RoomArr['total_cnb'] = $value['no_of_cnb'];
                $RoomArr['max_pax'] = $value['max_pax'];
                $RoomArr['min_pax'] = $value['min_pax'];
                $RoomArr['type'] = 1;
                $RoomArr['status'] = $value['status'];
                $offlineRoom =  OfflineRoom::create($RoomArr);
                $offlineRoom->roomamenity()->attach($value['room_amenities']);
                $offlineRoom->roomfreebies()->attach($value['room_freebies']);

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
        $RoomArr['meal_plan_id'] = $data['meal_plan'];
        $RoomArr['total_adult'] = $data['no_of_adult'];
        $RoomArr['total_cwb'] = $data['no_of_cwb'];
        $RoomArr['total_cnb'] = $data['no_of_cnb'];
        $RoomArr['max_pax'] = $data['max_pax'];
        $RoomArr['min_pax'] = $data['min_pax'];
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

        /**
         * Inser Room Price Data
         */
        $RoomPriceArr = [
            'room_id'     => $offlineroom->id,
            'from_date'     => $data['start_date'],
            'to_date'     => $data['end_date'],
            'single_adult_price'     => $data['single_occupancy'] ?? 0,
            'adult_price'     => $data['double_occupancy'] ?? 0,
            'extra_bed_price'     => $data['extra_pax_price'] ?? 0,
            'price_type'     => $data['price_type']
        ];
        $offlineRoomPrice =  OfflineRoomPrice::create($RoomPriceArr);

        /**
         * Inser Room Child Price Data
         */

        $RoomChildPriceArr = [
            'room_id'     => $offlineroom->id,
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
                OfflineRoomChildPrice::create($RoomChildPriceArr);
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


        $RoomPriceArr = [
            'from_date'     => $data['start_date'],
            'to_date'     => $data['end_date'],
            'single_adult_price'     => $data['single_occupancy'] ?? 0,
            'adult_price'     => $data['double_occupancy'] ?? 0,
            'extra_bed_price'     => $data['extra_pax_price'] ?? 0,
            'price_type'     => $data['price_type']
        ];
        $offlineroomprice->update($RoomPriceArr);

        $RoomChildPriceArr = [
            'from_date'     => $data['start_date'],
            'to_date'     => $data['end_date'],
        ];

        if (is_array($data['childrens']) && count($data['childrens']) > 0) {
            foreach ($data['childrens'] as $key => $value) {
                $RoomChildPriceArr['min_age'] = $value['main_age'];
                $RoomChildPriceArr['max_age'] = $value['max_age'];
                $RoomChildPriceArr['cwb_price'] = $value['cwb_price'];
                $RoomChildPriceArr['cnb_price'] = $value['cnb_price'];
                if (!isset($data['id'][$key]) || strlen($data['id'][$key]) == 0 || $data['id'][$key] == "" || $data['id'][$key] == NULL) {
                    $RoomChildPriceArr['room_id'] = $offlineroomprice->room_id;
                    $RoomChildPriceArr['price_id'] = $offlineroomprice->id;
                    OfflineRoomChildPrice::create($RoomChildPriceArr);
                } else {
                    OfflineRoomChildPrice::where('id', $data['id'][$key])->where('room_id', $data['room_id'])->where('price_id', $data['price_id'])->update($RoomChildPriceArr);
                }
            }
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
}
