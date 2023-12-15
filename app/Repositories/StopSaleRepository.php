<?php

namespace App\Repositories;

use App\Models\StopSale;
use Carbon\Carbon;
use DateTime;
use Exception;

class StopSaleRepository
{
   


    public function addStopSalePopup(array $data): StopSale
    {            
        $dataSave = [
            'hotel_id'    => $data['hotel_id'],           
            'stop_sale_date'    => isset($data['stop_sale_date']) ? Carbon::createFromFormat('d/m/Y', $data['stop_sale_date'])->format('Y-m-d') : '',         
        ];        
        return StopSale::create($dataSave);
    }

    public function addStopSalePopupUpdate(array $data): StopSale
    {
        $surcharge = StopSale::find($data['id']);
        
        $dataSave = [            
            'stop_sale_date'    => isset($data['stop_sale_date']) ? Carbon::createFromFormat('d/m/Y', $data['stop_sale_date'])->format('Y-m-d') : '',
        ];

        if ($surcharge->update($dataSave)) {
            return $surcharge;
        }        
    }
}
