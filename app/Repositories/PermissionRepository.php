<?php

namespace App\Repositories;

use App\Events\ForgotPasswordEvent;
use App\Exceptions\GeneralException;
use App\Models\Permission;
use App\Notifications\RegisterdEmailNotification;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Permission
     */
    public function create(array $data): Permission
    {
        $dataSave = [
            'name'    => $data['permission_name'],
            'slug'     => Str::slug($data['permission_name']),
        ];
        $permission =  Permission::create($dataSave);
        return $permission;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Permission $permission [explicite description]
     *
     * @return Permission
     * @throws Exception
     */
    public function update(array $data, Permission $permission): Permission
    {
        $dataUpdate = [
            'name'       => $data['permission_name'],
            'slug'       => Str::slug($data['permission_name'])
        ];
        if($permission->update($dataUpdate)){
            return $permission;
        }

        throw new Exception('Permission update failed.');
    }

     
    /**
     * Method delete
     *
     * @param Permission $permission [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Permission $permission): bool
    {
        //dd($permission);
        
    
        if ($permission->forceDelete()) {
            return true;
        }

        throw new Exception('Permission delete failed.');
    }
}
