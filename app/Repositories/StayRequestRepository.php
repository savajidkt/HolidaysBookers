<?php

namespace App\Repositories;

use App\Models\StayRequest;
use Exception;

class StayRequestRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return StayRequest
     */
    public function create(array $data): StayRequest
    {
       
        $dataSave = [
            'request'    => $data['request'],            
            'status'     => $data['status'],
        ];

        $stayRequest =  StayRequest::create($dataSave);
        return $stayRequest;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param StayRequest $stayRequest [explicite description]
     *
     * @return StayRequest
     * @throws Exception
     */
    public function update(array $data, StayRequest $stayRequest): StayRequest
    {
        $dataSave = [
            'request'    => $data['request'],            
            'status'     => $data['status'],
        ];


        if ($stayRequest->update($dataSave)) {
            return $stayRequest;
        }
        
        throw new Exception('Hotel Stay Request update failed!');
    }

    /**
     * Method delete
     *
     * @param StayRequest $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(StayRequest $stayRequest): bool
    {
        if ($stayRequest->forceDelete()) {
            return true;
        }

        throw new Exception('Hotel Stay Request delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, StayRequest $stayRequest): bool
    {
        $stayRequest->status = !$input['status'];
        return $stayRequest->save();
    }
}
