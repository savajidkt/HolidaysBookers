<?php

namespace App\Repositories;

use App\Models\Country;
use Exception;

class CountryRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Country
     */
    public function create(array $data): Country
    {
        $dataSave = [
            'name'    => $data['name'],
            'code'    => $data['code'],
            'phone_code'    => $data['phone_code'],
            'nationality'    => $data['nationality'],
            'status'     => $data['status'],
        ];

        $country =  Country::create($dataSave);
        return $country;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Country $country [explicite description]
     *
     * @return Country
     * @throws Exception
     */
    public function update(array $data, Country $country): Country
    {
        $dataSave = [
            'name'    => $data['name'],
            'code'    => $data['code'],
            'phone_code'    => $data['phone_code'],
            'nationality'    => $data['nationality'],
            'status'     => $data['status'],
        ];


        if ($country->update($dataSave)) {
            return $country;
        }

        throw new Exception(__('country/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param Country $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Country $country): bool
    {
        if ($country->forceDelete()) {
            return true;
        }

        throw new Exception(__('country/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Country $country): bool
    {
        $country->status = !$input['status'];
        return $country->save();
    }
}
