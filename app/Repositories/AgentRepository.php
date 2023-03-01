<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;
use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Notifications\RegisterdEmailNotification;

class AgentRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function create(array $data): User
    {

        $UserArr = [
            'first_name'    => $data['agent_first_name'],
            'last_name'    => $data['agent_last_name'],
            'email'    => $data['agent_username'],
            'password'    => Hash::make($data['agent_password']),
            'user_type'    => 1,
            'status'    => 1,
        ];

        $user =  User::create($UserArr);
        $UserProfileArr = [];
        $UserProfileArr['user_id'] = $user->id;
        $UserProfileArr['agent_code'] = 'CA';
        foreach ($data as $key => $value) {
            if ($key != "id" && $key != "_token") {
                if ($key == "agent_pan_card") {
                    $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_pan_card', $user->id);
                } else if ($key == "agent_company_certificate") {
                    $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_company_certificate', $user->id);
                } else if ($key == "agent_company_logo") {
                    $UserProfileArr[$key] = $this->uploadDoc($data, 'agent_company_logo', $user->id);
                } else {
                    $UserProfileArr[$key] = $data[$key];
                }
            }
        }

        $agent =  Agent::create($UserProfileArr);
        exit;
        //$user->notify(new RegisterdEmailNotification($password,$user));
        return $user;
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
     * @param User $user [explicite description]
     *
     * @return User
     * @throws Exception
     */
    public function update(array $data, User $user): User
    {
        $password = $data['password'];
        $data = [
            'company_id'    => $data['company'],
            'project_id'     => $data['project'],
            'first_name'     => $data['first_name'],
            'last_name'     => $data['last_name'],
            'address'       => $data['address'],
            'email'         => $data['email']
        ];

        if (isset($password)) {

            $data['password'] = Hash::make($password);
        }
        if ($user->update($data)) {
            return $user;
        }

        throw new Exception('User update failed.');
    }

    /**
     * Method delete
     *
     * @param User $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(User $user): bool
    {
        if ($user->forceDelete()) {
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
     * Method changePassword
     *
     * @param User $user
     * @param array $input
     *
     * @return void
     */
    public function changePassword(User $user, array $input)
    {
        // if(!Hash::check($input['current_password'], $user->password))
        // {
        //     throw new GeneralException('Entered current password is incorrect.');
        // }

        $data = [
            'password'                 => Hash::make($input['new_password']),
            'is_first_time_login'      => 1,
        ];
        //$input['password'] = Hash::make($input['new_password']);
        //$input['is_first_time_login'] = 1;

        //unset($input['current_password']);
        //unset($input['new_password']);
        //unset($input['password_confirmation']);

        if ($user->update($data)) {
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
        $user->user_status = !$input['status'];
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
