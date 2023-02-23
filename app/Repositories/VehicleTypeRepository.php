<?php

namespace App\Repositories;

use App\Models\VehicleType;
use Exception;

class VehicleTypeRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return VehicleType
     */
    public function create(array $data): VehicleType
    {
        $dataSave = [
            'vehicle_name'        => $data['vehicle_name'],
            'no_of_seats'        => $data['no_of_seats'],
            'status'     => $data['status'],
        ];

        $vehicletype =  VehicleType::create($dataSave);
        return $vehicletype;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param VehicleType $vehicletype [explicite description]
     *
     * @return VehicleType
     * @throws Exception
     */
    public function update(array $data, VehicleType $vehicletype): VehicleType
    {
        $dataSave = [
            'vehicle_name'        => $data['vehicle_name'],
            'no_of_seats'        => $data['no_of_seats'],
            'status'     => $data['status'],
        ];


        if ($vehicletype->update($dataSave)) {
            return $vehicletype;
        }

        throw new Exception(__('vehicletype/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param VehicleType $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(VehicleType $vehicletype): bool
    {
        if ($vehicletype->forceDelete()) {
            return true;
        }

        throw new Exception(__('vehicletype/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, VehicleType $vehicletype): bool
    {
        $vehicletype->status = !$input['status'];
        return $vehicletype->save();
    }
}
