<?php

namespace App\Repositories;

use App\Models\City;
use Exception;

class CityRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return City
     */
    public function create(array $data): City
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'state_id'    => $data['state_id'],
            'name'    => $data['name'],
            'status'     => $data['status'],
        ];

        $city =  City::create($dataSave);
        return $city;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param City $city [explicite description]
     *
     * @return City
     * @throws Exception
     */
    public function update(array $data, City $city): City
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'state_id'    => $data['state_id'],
            'name'    => $data['name'],
            'status'     => $data['status'],
        ];


        if ($city->update($dataSave)) {
            return $city;
        }

        throw new Exception(__('city/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param City $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(City $city): bool
    {
        if ($city->forceDelete()) {
            return true;
        }

        throw new Exception(__('city/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, City $city): bool
    {
        $city->status = !$input['status'];
        return $city->save();
    }
}
