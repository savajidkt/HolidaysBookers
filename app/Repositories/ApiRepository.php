<?php

namespace App\Repositories;

use App\Models\Api;
use Exception;

class ApiRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Api
     */
    public function create(array $data): Api
    {
        $dataSave = [
            'name'    => $data['name'],
            'api_url'    => $data['api_url'],
            'status'     => $data['status'],
        ];

        $api =  Api::create($dataSave);
        return $api;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Api $api [explicite description]
     *
     * @return Api
     * @throws Exception
     */
    public function update(array $data, Api $api): Api
    {
        $dataSave = [
            'name'    => $data['name'],
            'api_url'    => $data['api_url'],
            'status'     => $data['status'],
        ];


        if ($api->update($dataSave)) {
            return $api;
        }

        throw new Exception(__('api/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param Api $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Api $api): bool
    {
        if ($api->forceDelete()) {
            return true;
        }

        throw new Exception(__('api/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Api $api): bool
    {
        $api->status = !$input['status'];
        return $api->save();
    }
}
