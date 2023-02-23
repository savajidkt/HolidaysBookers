<?php

namespace App\Repositories;

use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use App\Models\User;
use App\Notifications\RegisterdEmailNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
        $password = $data['password'];
        $data = [
            'company_id'    => $data['company'],
            'project_id'     => $data['project'],
            'first_name'    => $data['first_name'],
            'last_name'     => $data['last_name'],
            'address'     => $data['address'],
            'email'         => $data['email'],
            'password'      => Hash::make($password),
        ];

        $user =  User::create($data);
        $user->notify(new RegisterdEmailNotification($password,$user));
        return $user;
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
        
        if( isset($password) )
        {
            
            $data['password'] = Hash::make($password);
           
        }
        if( $user->update($data) )
        {
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
        if( $user->forceDelete() )
        {
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
        try
        {
            if($user->trashed())
            {
                $user->restore();
            }

            event(new ForgotPasswordEvent($user));
        } catch (Exception $e)
        {
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

        if($user->update($data))
        {
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
            'other_text'    => $data['other_text']??null,
            'age'     => $data['age'],
            'ethnicity'     => $data['ethnicity'],
            'job_level'     => $data['job_level'],
            'years'       => $data['years']
        ];
        
       
        if( $user->update($data) )
        {
            return $user;
        }

        throw new Exception('User update failed.');
    }
}