<?php

namespace App\Repositories;

use App\Models\RoomType;
use Exception;

class RoomTypeRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return RoomType
     */
    public function create(array $data): RoomType
    {
        $dataSave = [
            'room_type'    => $data['room_type'],
            'status'     => $data['status'],
        ];

        $roomtype =  RoomType::create($dataSave);
        return $roomtype;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param RoomType $roomtype [explicite description]
     *
     * @return RoomType
     * @throws Exception
     */
    public function update(array $data, RoomType $roomtype): RoomType
    {
        $dataSave = [
            'room_type'    => $data['room_type'],
            'status'     => $data['status'],
        ];


        if ($roomtype->update($dataSave)) {
            return $roomtype;
        }

        throw new Exception(__('roomtype/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param RoomType $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(RoomType $roomtype): bool
    {
        if ($roomtype->forceDelete()) {
            return true;
        }

        throw new Exception(__('roomtype/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, RoomType $roomtype): bool
    {
        $roomtype->status = !$input['status'];
        return $roomtype->save();
    }
}
