<?php

namespace App\Repositories;

use App\Models\HotelFacility;
use Exception;

class HotelFacilityRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return HotelFacility
     */
    public function create(array $data, $icon): HotelFacility
    {
       
        $dataSave = [
            'name'    => $data['name'],
            'type'    => $data['type'],
            'icon'    => $icon,
            'status'     => $data['status'],
        ];

        $hotelfacility =  HotelFacility::create($dataSave);
        return $hotelfacility;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param HotelFacility $hotelfacility [explicite description]
     *
     * @return HotelFacility
     * @throws Exception
     */
    public function update(array $data, HotelFacility $hotelfacility, $icon): HotelFacility
    {
        $dataSave = [
            'name'    => $data['name'],
            'type'    => $data['type'],
            'icon'    => $icon,
            'status'     => $data['status'],
        ];


        if ($hotelfacility->update($dataSave)) {
            return $hotelfacility;
        }
        
        throw new Exception('Hotel facility update failed!');
    }

    /**
     * Method delete
     *
     * @param HotelFacility $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(HotelFacility $hotelfacility): bool
    {
        if ($hotelfacility->forceDelete()) {
            return true;
        }

        throw new Exception('Hotel facility delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, HotelFacility $hotelfacility): bool
    {
        $hotelfacility->status = !$input['status'];
        return $hotelfacility->save();
    }
}
