<?php

namespace App\Repositories;

use App\Models\AgentMarkup;
use Exception;

class AgentMarkupRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return AgentMarkup
     */
    public function create(array $data): AgentMarkup
    {
        $dataSave = [
            'code'    => $data['code'],
            'rezlive'    => $data['rezlive'],
            'offline_hotel'    => $data['offline_hotel'],
            'sightseeing'    => $data['sightseeing'],
            'transfer'    => $data['transfer'],
            'package'    => $data['package'],
            'status'     => $data['status'],
        ];

        $agentmarkup =  AgentMarkup::create($dataSave);
        return $agentmarkup;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param AgentMarkup $agentmarkup [explicite description]
     *
     * @return AgentMarkup
     * @throws Exception
     */
    public function update(array $data, AgentMarkup $agentmarkup): AgentMarkup
    {
        $dataSave = [
            'code'    => $data['code'],
            'rezlive'    => $data['rezlive'],
            'offline_hotel'    => $data['offline_hotel'],
            'sightseeing'    => $data['sightseeing'],
            'transfer'    => $data['transfer'],
            'package'    => $data['package'],
            'status'     => $data['status'],
        ];


        if ($agentmarkup->update($dataSave)) {
            return $agentmarkup;
        }

        throw new Exception(__('agent-markup/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param AgentMarkup $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(AgentMarkup $agentmarkup): bool
    {
        if ($agentmarkup->forceDelete()) {
            return true;
        }

        throw new Exception(__('agent-markup/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, AgentMarkup $agentmarkup): bool
    {
        $agentmarkup->status = !$input['status'];
        return $agentmarkup->save();
    }
}
