<?php

namespace App\Imports;

use App\Models\Country;
use App\Models\State;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

class StatesImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {

        if (strlen(trim($row['countryname'])) > 0) {
            if (strlen(trim($row['statename'])) > 0) {
                if (strlen(trim($row['statecode'])) > 0) {
                    $Country = Country::where('name', $row['countryname'])->first();
                    if ($Country->count() > 0) {
                        return new State([
                            "country_id" => $Country->id,
                            "name" => $row['statename'],
                            "code" => $row['statecode'],
                            "status" => 1
                        ]);
                    }
                }
            }
        }
    }
}
