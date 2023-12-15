<?php

namespace App\Repositories;

use App\Models\Complimentary;
use Carbon\Carbon;
use DateTime;
use Exception;

class ComplimentaryRepository
{
   


    public function addComplimentaryPopup(array $data): Complimentary
    {            
        $dataSave = [
            'hotel_id'    => $data['hotel_id'],
            'room_id'    => $data['id'],
            'complimentary_name'    => $data['complimentary_name'],
            'complimentary_price'    => $data['complimentary_price']            
        ];        
        return Complimentary::create($dataSave);
    }

    public function addComplimentaryPopupUpdate(array $data): Complimentary
    {
        $surcharge = Complimentary::find($data['id']);
        
        $dataSave = [            
            'complimentary_name'    => $data['complimentary_name'],
            'complimentary_price'    => $data['complimentary_price']
        ];

        if ($surcharge->update($dataSave)) {
            return $surcharge;
        }        
    }
}
