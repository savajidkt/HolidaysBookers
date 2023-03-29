<?php

namespace App\Imports;

use App\Models\City;
use App\Models\State;
use App\Models\Country;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RezliveCitiesImport implements ToModel, WithHeadingRow
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
                if (strlen(trim($row['cityname'])) > 0) {
                    $states = State::where('name', $row['statename'])->first();
                    if ($states->count() > 0) {
                        return new City([
                            "country_id" => $states->country_id,
                            "state_id" => $states->id,
                            "name" => $row['cityname'],
                            "rezlive_city_code" => $row['rezlivecitycode'],
                            "status" => 1
                        ]);
                    }
                }
            }
        }
    }
}
