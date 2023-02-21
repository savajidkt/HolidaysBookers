<?php

namespace App\Repositories;

use App\Models\Amenity;
use Exception;

class AmenityRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Amenity
     */
    public function create(array $data): Amenity
    {
        $dataSave = [
            'amenity_name'    => $data['amenity_name'],
            'type'    => $data['type'],
            'status'     => $data['status'],
        ];

        $amenity =  Amenity::create($dataSave);        
        return $amenity;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Amenity $amenity [explicite description]
     *
     * @return Amenity
     * @throws Exception
     */
    public function update(array $data, Amenity $amenity): Amenity
    {
        $dataSave = [
            'amenity_name'    => $data['amenity_name'],
            'type'    => $data['type'],
            'status'     => $data['status'],
        ];


        if($amenity->update($dataSave))
        {           
            return $amenity;
        }

        throw new Exception('Amenity name update failed.');
    }

    /**
     * Method delete
     *
     * @param Amenity $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Amenity $amenity): bool
    {
        if( $amenity->forceDelete() )
        {
            return true;
        }

        throw new Exception('Amenity name delete failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Amenity $amenity): bool
    {
        $amenity->status = !$input['status'];
        return $amenity->save();
    }

}