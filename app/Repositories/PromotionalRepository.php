<?php

namespace App\Repositories;

use App\Models\Promotional;
use Carbon\Carbon;
use DateTime;
use Exception;

class PromotionalRepository
{
   


    public function addPromotionalPopup(array $data): Promotional
    {           
        $dates = explode(' to ', $data['date_validity']);  
        $dataSave = [
            'hotel_id'    => $data['hotel_id'],
            'room_id'    => $data['room_id'],
            'single_adult'    => $data['single_adult'],
            'per_room'    => $data['per_room'],
            'extra_adult'    => $data['extra_adult'],
            'child_with_bed'    => $data['child_with_bed'],
            'child_with_no_bed_0_4'    => $data['child_with_no_bed_0_4'],
            'child_with_no_bed_5_12'    => $data['child_with_no_bed_5_12'],
            'child_with_no_bed_13_18'    => $data['child_with_no_bed_13_18'],
            'date_validity_start'    => isset($dates[0]) ? Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d') : '',
            'date_validity_end'    => isset($dates[1]) ? Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d') : '',            
            'apply_for'    => $data['apply_for_p'],
        ];        
        return Promotional::create($dataSave);
    }

    public function addPromotionalPopupUpdate(array $data): Promotional
    {
        $surcharge = Promotional::find($data['id']);
        $dates = explode(' to ', $data['date_validity']); 
        $dataSave = [            
            'single_adult'    => $data['single_adult'],
            'per_room'    => $data['per_room'],
            'extra_adult'    => $data['extra_adult'],
            'child_with_bed'    => $data['child_with_bed'],
            'child_with_no_bed_0_4'    => $data['child_with_no_bed_0_4'],
            'child_with_no_bed_5_12'    => $data['child_with_no_bed_5_12'],
            'child_with_no_bed_13_18'    => $data['child_with_no_bed_13_18'],
            'date_validity_start'    => isset($dates[0]) ? Carbon::createFromFormat('d/m/Y', $dates[0])->format('Y-m-d') : '',
            'date_validity_end'    => isset($dates[1]) ? Carbon::createFromFormat('d/m/Y', $dates[1])->format('Y-m-d') : '',            
            'apply_for'    => $data['apply_for_p'],
        ];

        if ($surcharge->update($dataSave)) {
            return $surcharge;
        }        
    }
}
