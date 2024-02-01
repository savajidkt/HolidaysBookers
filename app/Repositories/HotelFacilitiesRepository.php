<?php

namespace App\Repositories;

use App\Models\HotelFacilities;
use Exception;

class HotelFacilitiesRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return HotelFacilities
     */
    public function create(array $data): HotelFacilities
    {
        $dataSave = [
            'facility_id'    => $data['facility_id'],
            'name'    => $data['name'],            
            'status'     => $data['status'],
        ];

        $hotelfacilities =  HotelFacilities::create($dataSave);
        return $hotelfacilities;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param HotelFacilities $hotelfacilities [explicite description]
     *
     * @return HotelFacilities
     * @throws Exception
     */
    public function update(array $data, HotelFacilities $hotelfacilities): HotelFacilities
    {
        $dataSave = [
            'facility_id'    => $data['facility_id'],
            'name'    => $data['name'],            
            'status'     => $data['status'],
        ];


        if ($hotelfacilities->update($dataSave)) {
            return $hotelfacilities;
        }

        throw new Exception('Hotel facilities update failed!');
    }

    /**
     * Method delete
     *
     * @param HotelFacilities $user [explicite description]
     *
     * @return HotelFacilities
     * @throws Exception
     */
    public function delete(HotelFacilities $hotelfacilities): HotelFacilities
    {
        if ($hotelfacilities->forceDelete()) {
            return $hotelfacilities;
        }

        throw new Exception('Hotel facilities delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, HotelFacilities $hotelfacilities): bool
    {
        $hotelfacilities->status = !$input['status'];
        return $hotelfacilities->save();
    }
}
