<?php
     
namespace App\Http\Traits;

use App\Models\Api;
 
trait GlobalTrait {
 
    public function getAllSettings($api)
    {
        // Fetch all the settings from the 'settings' table.
        $settings = Api::find($api);
        return $settings;
    }
}