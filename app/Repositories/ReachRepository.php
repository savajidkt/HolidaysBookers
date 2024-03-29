<?php

namespace App\Repositories;

use App\Models\Reach;
use Exception;

class ReachRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Reach
     */
    protected $table = "reachus";
    public function create(array $data): Reach
    {
        $dataSave = [
            'name'    => $data['name'],
            'show_other_textbox'    => $data['show_other_textbox'],
            'textbox_lable'    => $data['textbox_lable'],
            'status'     => $data['status'],
        ];

        $reach =  Reach::create($dataSave);
        return $reach;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Reach $reach [explicite description]
     *
     * @return Reach
     * @throws Exception
     */
    public function update(array $data, Reach $reach): Reach
    {
        // Create an array with the data you want to save
        $dataSave = [
            'name'    => $data['name'],
            'show_other_textbox' => $data['show_other_textbox'],
            'status' => $data['status'],
        ];

        // Check if show_other_textbox is 'no'
        if ($data['show_other_textbox'] == 0) {
            // Set textbox_lable to an empty string
            $dataSave['textbox_lable'] = '';
        } else {
            // Set textbox_lable to the value provided in $data
            $dataSave['textbox_lable'] = $data['textbox_lable'];
        }

        // Update the record with the modified data
        if ($reach->update($dataSave)) {
            return $reach;
        }

        throw new Exception(__('reach-us/message.updated_error'));
    }

    /**
     * Method delete
     *
     * @param Reach $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Reach $reach): bool
    {
        if ($reach->forceDelete()) {
            return true;
        }

        throw new Exception(__('reach-us/message.deleted_error'));
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Reach $reach): bool
    {
        $reach->status = !$input['status'];
        return $reach->save();
    }
}
