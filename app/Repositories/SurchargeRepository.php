<?php

namespace App\Repositories;

use App\Models\Surcharge;
use Carbon\Carbon;
use DateTime;
use Exception;

class SurchargeRepository
{
    
    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Surcharge $mealplan [explicite description]
     *
     * @return Surcharge
     * @throws Exception
     */
    public function update(array $data, Surcharge $mealplan): Surcharge
    {
        $dataSave = [
            'name'    => $data['name'],
            'status'     => $data['status'],
        ];
        if ($mealplan->update($dataSave)) {
            return $mealplan;
        }
        throw new Exception('Meal plan update failed!');
    }

    /**
     * Method delete
     *
     * @param Surcharge $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Surcharge $mealplan): bool
    {
        if ($mealplan->delete()) {
            return true;
        }

        throw new Exception('Meal plan delete failed!');
    }


    public function addSurchargesPopup(array $data): Surcharge
    {
        $dates = explode(' to ', $data['surcharge_date']);          
        $dataSave = [
            'hotel_id'    => $data['hotel_id'],
            'room_id'    => $data['room_id'],
            'surcharge_name'    => $data['surcharge_name'],
            'surcharge_price'    => $data['surcharge_price'],
            'surcharge_date_start'    => isset($dates[0]) ? Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d') : '',
            'surcharge_date_end'    => isset($dates[1]) ? Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d') : '',            
            'apply_for'    => $data['apply_for'],
        ];
        
        return Surcharge::create($dataSave);
    }

    public function addSurchargesPopupUpdate(array $data): Surcharge
    {
        $surcharge = Surcharge::find($data['id']);
        $dates = explode(' to ', $data['surcharge_date']);          
        $dataSave = [            
            'surcharge_name'    => $data['surcharge_name'],
            'surcharge_price'    => $data['surcharge_price'],
            'surcharge_date_start'    => isset($dates[0]) ? Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d') : '',
            'surcharge_date_end'    => isset($dates[1]) ? Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d') : '',            
            'apply_for'    => $data['apply_for'],
        ];

        if ($surcharge->update($dataSave)) {
            return $surcharge;
        }        
    }
}
