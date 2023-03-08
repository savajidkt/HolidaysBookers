<?php

namespace App\Exports;

use App\Models\Customer;
use Illuminate\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Events\BeforeExport;

class ExportCustomers implements FromView, WithEvents
{
    protected $customers;

    function __construct($customers)
    {
        $this->customers = $customers;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {      
        return view('admin.customers.customer-export', [
            'customers' => $this->customers
        ]);
    }

    /**
     * @return array
     */
    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $columns = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L'];
                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);
                }
            },

        ];
    }
}
