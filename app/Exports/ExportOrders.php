<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ExportOrders implements FromCollection, WithMapping, WithHeadings
{
    public $order;

    /**
     * @return \Illuminate\Support\Collection
     */

    public function __construct(Order $order)
    {

        $this->order = $order;
    }

     // set the collection of members to export
     public function collection()
     {       
         return $this->order;
     }

    public function map($order): array
    {
        
        return [
            $order->prn_number,
            $order->invoice_no,
            $order->confirmation_no,
            $order->booking_amount,
            $order->booking_currency,
            $order->agent_code,
            $order->agent_email,            
            $order->total_adult,
            $order->total_child,
            $order->total_rooms,
            paymentMethodName($order->is_pay_using),
            ($order->passenger_type == 1) ? 'All' : 'Lead Passenger',
        ];
    }

    public function headings(): array
    {
        return [
            'PNR No',
            'Invoice No',
            'Confirmation No',
            'Booking Amount',
            'Booking Currency',
            'Agent Code',
            'Agent Email',
            'Adult',
            'Child',
            'Room',            
            'Payment Method',
            'Passenger Type',
        ];
    }
}
