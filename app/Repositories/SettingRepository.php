<?php

namespace App\Repositories;


use App\Models\Setting;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingRepository
{
    /**
     * Method create
     *
     * @param array $data [explicite description]
     *
     * @return Setting
     */
    public function create(array $data): Setting
    {
        unset($data['_token']);        
        $dataSave = [
            'type'    => $data['type'],
            'settings_data'     => serialize($data),
        ];

        $role =  Setting::create($dataSave);        
        return $role;
    }

    /**
     * Method update
     *
     * @param array $data [explicite description]
     * @param Setting $role [explicite description]
     *
     * @return Setting
     * @throws Exception
     */
    public function update(array $data, Setting $setting): Setting
    {
        $id = $data['setting_id'];
        unset($data['_method']);    
        unset($data['_token']);    
        unset($data['type']);    
        unset($data['setting_id']);    
        $dataSave = [            
            'settings_data'     => serialize($data),
        ];


        if($setting->update($dataSave))
        {   
           
            return $setting;
        }

        throw new Exception('Setting update failed.');
    }

    /**
     * Method delete
     *
     * @param setting $user [explicite description]
     *
     * @return bool
     * @throws Exception
     */
    public function delete(Setting $setting): bool
    {
        if( $setting->forceDelete() )
        {
            return true;
        }

        throw new Exception('Setting delete failed.');
    }
}