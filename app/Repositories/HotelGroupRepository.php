<?php

namespace App\Repositories;

use App\Exceptions\GeneralException;
use App\Models\HotelGroup;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class HotelGroupRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return HotelGroup
     */
    public function create(array $data): HotelGroup
    {
        $dataSave = [
            'name'    => $data['group_name'],
            'status'    => $data['status']
        ];

        $hotelGroup =  HotelGroup::create($dataSave);
        return $hotelGroup;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param HotelGroup $hotelGroup [explicite description]
     *
     * @return HotelGroup
     * @throws Exception
     */
    public function update(array $data, HotelGroup $hotelGroup): HotelGroup
    {
        $dataSave = [
            'name'    => $data['group_name'],
            'status'     => $data['status'],
        ];


        if ($hotelGroup->update($dataSave)) {
            return $hotelGroup;
        }

        throw new Exception(__('hotel-group/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param HotelGroup $hotelGroup [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(HotelGroup $hotelGroup): bool
    {
        if ($hotelGroup->forceDelete()) {
            return true;
        }
        throw new Exception(__('hotel-group/message.deleted_error'));
    }
    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, HotelGroup $hotelgroup): bool
    {
        $hotelgroup->status = !$input['status'];
        return $hotelgroup->save();
    }
    
    /**
     * Method addGroupPopup
     *
     * @param array $data [explicite description]
     *
     * @return HotelGroup
     */
    public function addGroupPopup(array $data): HotelGroup
    {
        $dataSave = [
            'name'    => $data['name'],
            'status'  => HotelGroup::ACTIVE,
        ];

        $group =  HotelGroup::create($dataSave);
        return $group;
    }
}
