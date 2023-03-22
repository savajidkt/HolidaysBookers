<?php

namespace App\Repositories;

use App\Models\Freebies;
use Exception;

class FreebiesRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Freebies
     */
    public function create(array $data): Freebies
    {
        $dataSave = [
            'name'    => $data['name'],
            'type'    => $data['type'],
            'status'     => $data['status'],
        ];

        $freebies =  Freebies::create($dataSave);
        return $freebies;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Freebies $freebies [explicite description]
     *
     * @return Freebies
     * @throws Exception
     */
    public function update(array $data, Freebies $freebies): Freebies
    {
        $dataSave = [
            'name'    => $data['name'],
            'type'    => $data['type'],
            'status'     => $data['status'],
        ];


        if ($freebies->update($dataSave)) {
            return $freebies;
        }

        throw new Exception('Freebies update failed!');
    }

    /**
     * Method delete
     *
     * @param Freebies $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Freebies $freebies): bool
    {
        if ($freebies->forceDelete()) {
            return true;
        }

        throw new Exception('Freebies delete failed!');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Freebies $freebies): bool
    {
        $freebies->status = !$input['status'];
        return $freebies->save();
    }



    /**
     * Method addFreebiesPopup
     *
     * @param array $data [explicite description]
     *
     * @return Freebies
     */
    public function addFreebiesPopup(array $data): Freebies
    {
        $dataSave = [
            'name'    => $data['name'],
            'type'    => $data['type'] ?? Freebies::ROOM,
            'status'     => 1,
        ];

        $freebies =  Freebies::create($dataSave);
        return $freebies;
    }
}
