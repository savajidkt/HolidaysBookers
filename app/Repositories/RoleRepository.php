<?php

namespace App\Repositories;

use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use App\Models\Role;
use App\Notifications\RegisterdEmailNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Role
     */
    public function create(array $data): Role
    {
        $dataSave = [
            'name'    => $data['rolename'],
            'slug'     => Str::slug($data['rolename']),
        ];

        $role =  Role::create($dataSave);
        $role->permissions()->attach($data['permissions']);
        //$admin->notify(new RegisterdEmailNotification($password,$admin));
        return $role;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Role $role [explicite description]
     *
     * @return Role
     * @throws Exception
     */
    public function update(array $data, Role $role): Role
    {
        $dataSave = [
            'name'    => $data['rolename'],
            'slug'     => Str::slug($data['rolename']),
        ];


        if($role->update($dataSave))
        {   if(isset($data['permissions'])){
                $role->permissions()->detach();
                $role->permissions()->attach($data['permissions']);
            }
           
            return $role;
        }

        throw new Exception('Role update failed.');
    }

    /**
     * Method delete
     *
     * @param Role $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Role $role): bool
    {
        if( $role->forceDelete() )
        {
            return true;
        }

        throw new Exception('Role delete failed.');
    }

     /**
     * Method changeStatus
     *
     * @param array $input [explicite description]
     *
     * @return bool
     */
    public function changeStatus(array $input, Role $role): bool
    {
        $role->status = !$input['status'];
        return $role->save();
    }

}