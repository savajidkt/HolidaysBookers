<?php

namespace App\Imports;

use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class CountriesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if (strlen(trim($row['countryname'])) > 0) {
            if (strlen(trim($row['countrycode'])) > 0) {
                if (strlen(trim($row['phonecode'])) > 0) {
                    if (strlen(trim($row['nationality'])) > 0) {
                        return new Country([
                            "name" => $row['countryname'],
                            "code" => $row['countrycode'],
                            "phone_code" => $row['phonecode'],
                            "nationality" => $row['nationality'],
                            "status" => 1
                        ]);
                    }
                }
            }
        }
    }
}
