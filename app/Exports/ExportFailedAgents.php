<?php

namespace App\Exports;

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportFailedAgents implements FromCollection, WithHeadings
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
            'Company Name',
            'Firm Company Type',
            'Nature of Business',
            'First Name',
            'Last Name',
            'Designation',
            'Date Of Birth',
            'Office address',
            'Country',
            'State',
            'City',
            'Zipcode',
            'Telephone',
            'Mobile Number',
            'Email Address',
            'Website',
            'IATA certified',
            'IATA Number',
            'Other Certification',
            'PAN Number',
            'GST Number',
            'Know About',
            'Know Other',
            'Management First Name',
            'Management Last Name',
            'Management Contact Number',
            'Management Email Address',
            'Accounts First Name',
            'Accounts Last Name',
            'Accounts Contact Number',
            'Accounts Email Address',
            'Operations First Name',
            'Operations Last Name',
            'Operations Contact Number',
            'Operations Email Address',
            'Login Email',
            'Password',
            'Confirm Password'
        ];
    }
}
