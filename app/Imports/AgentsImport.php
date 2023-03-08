<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\City;
use App\Models\User;
use App\Models\Agent;
use App\Models\CompanyType;
use App\Models\State;
use App\Models\Country;
use App\Models\Reach;
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

class AgentsImport implements ToCollection, WithStartRow
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
                        'first_name'    => $row[3],
                        'last_name'    => $row[4],
                        'email'    => $row[35],
                        'password'    => Hash::make($row[36]),
                        'user_type'    => 1,
                        'status'    => 1,
                    ];

                    $user =  User::create($UserArr);

                    $agent_country = Country::select('id')->where('name', $row[8])->first();
                    $agent_state = State::where('name', $row[9])->first();
                    $agent_city =  City::where('name', $row[10])->first();
                    $reachus =  Reach::where('name', $row[21])->first();
                    $company_type =  CompanyType::where('company_type', $row[1])->first();

                    $UserProfileArr = [];
                    $UserProfileArr['user_id'] = $user->id;
                    $UserProfileArr['agent_country'] = $agent_country->id;
                    $UserProfileArr['agent_state'] = $agent_state->id;
                    $UserProfileArr['agent_city'] = $agent_city->id;
                    $UserProfileArr['agent_code'] = createAgentCode($user->id);
                    $UserProfileArr['agent_company_name'] = $row[35];
                    $UserProfileArr['agent_company_type'] = $company_type->id;
                    $UserProfileArr['nature_of_business'] = $row[2];
                    $UserProfileArr['agent_first_name'] = $row[3];
                    $UserProfileArr['agent_last_name'] = $row[4];
                    $UserProfileArr['agent_designation'] = $row[5];
                    $UserProfileArr['agent_dob'] = excelDateConvert($row[6]);
                    $UserProfileArr['agent_office_address'] = $row[7];
                    $UserProfileArr['agent_pincode'] = $row[11];
                    $UserProfileArr['agent_telephone'] = $row[12];
                    $UserProfileArr['agent_mobile_number'] = $row[13];
                    $UserProfileArr['agent_email'] = $row[14];
                    $UserProfileArr['agent_website'] = $row[15];
                    $UserProfileArr['agent_iata'] = $row[16];
                    $UserProfileArr['agent_iata_number'] = $row[17];
                    $UserProfileArr['agent_other_certification'] = $row[18];
                    $UserProfileArr['agent_pan_number'] = $row[19];
                    $UserProfileArr['agent_gst_number'] = $row[20];
                    $UserProfileArr['mgmt_first_name'] = $row[23];
                    $UserProfileArr['mgmt_last_name'] = $row[24];
                    $UserProfileArr['mgmt_contact_number'] = $row[25];
                    $UserProfileArr['mgmt_email'] = $row[26];
                    $UserProfileArr['account_first_name'] = $row[27];
                    $UserProfileArr['account_last_name'] = $row[28];
                    $UserProfileArr['account_contact_number'] = $row[29];
                    $UserProfileArr['account_email'] = $row[30];
                    $UserProfileArr['reserve_first_name'] = $row[31];
                    $UserProfileArr['reserve_last_name'] = $row[32];
                    $UserProfileArr['reserve_contact_number'] = $row[33];
                    $UserProfileArr['reserve_email'] = $row[34];
                    $UserProfileArr['agent_know_about'] = $reachus->id;
                    $UserProfileArr['othername'] = $row[22];

                    $agent =  Agent::create($UserProfileArr);
                    $WalletTransaction =  [
                        'user_id'    => $user->id,
                        'agent_id'    => $agent->id,
                        'comment'    => 'Import Agent By Excel',
                    ];
                    WalletTransaction::create($WalletTransaction);
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
            if ($key == 6) {
                $newArr[$key] = excelDateConvert($value);
            } else {
                $newArr[$key] = $value;
            }
            //$newArr[$key] = $value;
        }
        return $newArr;
    }

    public function requiredFilds($row)
    {
        for ($i = 0; $i < count($row); $i++) {
            if ($i != 12 && $i != 15 && $i != 18 && $i != 19 && $i != 20 && $i != 21 && $i != 22) {
                if ($i == 8) {
                    $country = Country::where('name', $row[8])->first();
                    if (!$country) {
                        return false;
                    }
                } else if ($i == 9) {
                    $States = State::where('name', $row[9])->first();
                    if (!$States) {
                        return false;
                    }
                } else if ($i == 10) {
                    $city = City::where('name', $row[10])->first();
                    if (!$city) {
                        return false;
                    }
                } else if ($i == 16 && $row[$i] == "yes") {
                    if (strlen($row[$i + 1]) == 0 || $row[$i + 1] == "") {
                        return false;
                    }
                } else if ($i == 17) {
                    if ($row[16] == "yes") {                       
                        if (strlen($row[$i]) == 0 || $row[$i] == "") {
                            return false;
                        }
                    }
                } else if ($i == 35) {
                    $userArr = User::where('email', $row[$i])->first();
                    if ($userArr) {
                        return false;
                    }
                } else if ($i == 36) {
                    if ($row[$i] != $row[$i + 1]) {
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
