<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Customer;
use App\Models\State;
use App\Models\Country;
use App\Models\WalletTransaction;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Notifications\Notifiable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Database\Eloquent\SoftDeletes;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomersImport implements ToCollection, WithStartRow
{
    use HasApiTokens, HasFactory, SoftDeletes, Notifiable;

    public function startRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {

        $skip = [];
        $skip['sucess'] = 0;
        $skip['skip'] = [];
        $skip['download_skip_data'] = array();
        $suc = 1;
        $total_count = 0;
        $skipArray = array();


        foreach ($rows as $row) {
            if ($row) {
                $total_count++;
                if ($this->requiredFilds($row)) {

                    $UserArr =  [
                        'first_name'    => $row[0],
                        'last_name'    => $row[1],
                        'email'    => $row[9],
                        'password'    => Hash::make($row[10]),
                        'user_type'    => 2,
                        'status'    => 1,
                    ];

                    $user =  User::create($UserArr);

                    $agent_country = Country::select('id')->where('name', $row[3])->first();
                    $agent_state = State::where('name', $row[4])->first();
                    $agent_city =  City::where('name', $row[5])->first();

                    $UserProfileArr = [];
                    $UserProfileArr['user_id'] = $user->id;
                    $UserProfileArr['country'] = $agent_country->id;
                    $UserProfileArr['state'] = $agent_state->id;
                    $UserProfileArr['city'] = $agent_city->id;
                    $UserProfileArr['dob'] = excelDateConvert($row[2]);
                    $UserProfileArr['zipcode'] = $row[6];
                    $UserProfileArr['telephone'] = $row[7];
                    $UserProfileArr['mobile_number'] = $row[8];
                    Customer::create($UserProfileArr);

                    $skip['sucess'] = $suc;
                    $suc++;
                } else {
                    $skip['skip'][] = $row[0];
                    $skipArray[] = $this->skipArrayCollection($row);
                }
            }
        }

        if (is_array($skipArray) && count($skipArray) > 0) {
            $skip['download_skip_data'] = $skipArray;
        }

        $skip['total'] = $total_count;
        session()->put('skip_row', $skip);
    }


    public function skipArrayCollection($row)
    {
        $newArr = array();
        foreach ($row as $key => $value) {
            if ($key == 2) {
                $newArr[$key] = excelDateConvert($value);
            } else {
                $newArr[$key] = $value;
            }
        }
        return $newArr;
    }

    public function requiredFilds($row)
    {
        for ($i = 0; $i < count($row); $i++) {
            if ($i != 7) {
                if ($i == 3) {
                    $country = Country::where('name', $row[3])->first();
                    if (!$country) {
                        return false;
                    }
                } else if ($i == 4) {
                    $States = State::where('name', $row[4])->first();
                    if (!$States) {
                        return false;
                    }
                } else if ($i == 5) {
                    $city = City::where('name', $row[5])->first();
                    if (!$city) {
                        return false;
                    }
                } else if ($i == 9) {
                    $userArr = User::where('email', $row[$i])->first();
                    if ($userArr) {
                        return false;
                    }
                } else if (strlen($row[$i]) == 0 || $row[$i] == " ") {
                    return false;
                }
            }
        }

        return true;
    }
}
