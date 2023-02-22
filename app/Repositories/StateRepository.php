<?php

namespace App\Repositories;

use App\Models\State;
use Exception;

class StateRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return State
     */
    public function create(array $data): State
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'name'    => $data['name'],
            'code'    => $data['code'],
            'status'     => $data['status'],
        ];

        $state =  State::create($dataSave);
        return $state;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param State $state [explicite description]
     *
     * @return State
     * @throws Exception
     */
    public function update(array $data, State $state): State
    {
        $dataSave = [
            'country_id'    => $data['country_id'],
            'name'    => $data['name'],
            'code'    => $data['code'],
            'status'     => $data['status'],
        ];


        if ($state->update($dataSave)) {
            return $state;
        }

        throw new Exception('State update failed.');
    }

    /**
     * Method delete
     *
     * @param State $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(State $state): bool
    {
        if ($state->forceDelete()) {
            return true;
        }

        throw new Exception('State delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, State $state): bool
    {
        $state->status = !$input['status'];
        return $state->save();
    }
}