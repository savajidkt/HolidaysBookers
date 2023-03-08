<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportFailedCustomers implements FromCollection, WithHeadings
{

    protected $data;

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function collection()
    {
        return collect($this->data);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return [           
            'First Name',
            'Last Name',            
            'Date Of Birth',            
            'Country',
            'State',
            'City',
            'Zipcode',
            'Telephone',
            'Mobile Number',            
            'Email',
            'Password',
            'Confirm Password'
        ];
    }
}
