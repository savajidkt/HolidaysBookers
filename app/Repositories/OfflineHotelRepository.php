<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use App\Models\OfflineHotel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\RegisterdEmailNotification;

class OfflineHotelRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return OfflineHotel
     */
    public function create(array $data): OfflineHotel
    {

        $HotelArr = [
            'hotel_name'    => $data['hotel_name'],
            'hotel_country'  => $data['hotel_country'],
            'hotel_state'    => $data['hotel_state'],
            'hotel_city'    => $data['hotel_city'],
            'category'      => $data['category'],
            'hotel_group_id'    => $data['hotel_group_id'],
            'phone_number'    => $data['phone_number'],
            'fax_number'    => $data['fax_number'],
            'hotel_address'    => $data['hotel_address'],
            'hotel_pincode'    => $data['hotel_pincode'],
            'hotel_email'    => $data['hotel_email'],
            'hotel_amenities'    => $data['hotel_amenities'],
            'property_type_id'    => $data['property_type_id'],
            'hotel_review'    => $data['hotel_review'],
            'hotel_latitude'    => $data['hotel_latitude'],
            'hotel_longitude'    => $data['hotel_longitude'],
            'cancel_days'    => $data['cancel_days'],
            'hotel_description'    => $data['hotel_description'],
            'cancellation_policy'    => $data['cancellation_policy'],            
            'status'    => OfflineHotel::ACTIVE,
        ];

        $OfflineHotel = OfflineHotel::create($HotelArr);
        _P($OfflineHotel);
        exit;
        //$user->notify(new RegisterdEmailNotification($password,$user));
        return $OfflineHotel;
    }


    /**
     * Method uploadDoc
     *
     * @param $data $data [explicite description]
     * @param $filename $filename [explicite description]
     *
     * @return void
     */
    public function uploadDoc($data, $filename, $user_id)
    {
        if (strlen($data[$filename]) > 0) {
            FolderExists($user_id);
            return FileUpload($data[$filename], 'upload/' . $user_id);
        } else {
            return "";
        }
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Agent $agent [explicite description]
     *
     * @return Agent
     * @throws Exception
     */
    public function update(array $data, Agent $agent): Agent
    {


        $password = $data['agent_password'];
        $UserArr = [
            'first_name'    => $data['agent_first_name'],
            'last_name'    => $data['agent_last_name'],
            'email'    => $data['agent_username'],
            'user_type'    => 1,
            'status'    => 1,
        ];
        if (isset($password)) {
            $UserArr['password'] = Hash::make($password);
        }

        if ($agent->user->update($UserArr)) {

            $UserProfileArr = [];
            foreach ($data as $key => $value) {
                if ($key != "id" && $key != "_token") {
                    if ($key == "agent_pan_card") {
                        $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_pan_card', $agent->user->id);
                    } else if ($key == "agent_company_certificate") {
                        $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_company_certificate', $agent->user->id);
                    } else if ($key == "agent_company_logo") {
                        $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_company_logo', $agent->user->id);
                    } else {
                        $UserProfileArr[$key] = $data[$key];
                    }
                }
            }

            $agent->update($UserProfileArr);
            //$agent->notify(new RegisterdEmailNotification($password,$agent));
        }
        return $agent;
        throw new Exception('User update failed.');
    }

    /**
     * Method delete
     *
     * @param Agent $agent [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Agent $agent): bool
    {
        if ($agent->user->forceDelete()) {
            return true;
        }

        throw new Exception('User delete failed.');
    }


    public function forgotPassword(array $input)
    {
        $token = \Illuminate\Support\Str::random(64);
        DB::table('password_resets')->insert([
            'email' => $input['email'],
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
        $user = User::withTrashed()->where('email', $input['email'])->first();

        // Event for forgot password
        try {
            if ($user->trashed()) {
                $user->restore();
            }

            event(new ForgotPasswordEvent($user));
        } catch (Exception $e) {
            // Failed to dispatch event
            report($e);
        }
    }

    /**
     * Method updatePassword
     *
     * @param array $input [explicite description]
     * @param User $user [explicite description]
     *
     * @return void
     */
    public function updatePassword(array $input, User $user)
    {
        $UserArr = [
            'password'    => Hash::make($input['password'])
        ];

        if ($user->update($UserArr)) {
            return true;
        }

        throw new GeneralException('Change password failed.');
    }

    /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, User $user): bool
    {
        $user->status = !$input['status'];
        return $user->save();
    }

    public function resetSurveyTime(array $input, UserSurvey $userSurvey): bool
    {
        return $userSurvey->delete();
    }

    /**
     * Method demoformcreate
     *
     * @param array $data [explicite description]
     * @param User $user [explicite description]
     *
     * @return User
     * @throws Exception
     */
    public function demoformcreate(array $data): User
    {
        $user = auth()->user();
        $data = [
            'gender'    => $data['gender'],
            'other_text'    => $data['other_text'] ?? null,
            'age'     => $data['age'],
            'ethnicity'     => $data['ethnicity'],
            'job_level'     => $data['job_level'],
            'years'       => $data['years']
        ];


        if ($user->update($data)) {
            return $user;
        }

        throw new Exception('User update failed.');
    }
}
