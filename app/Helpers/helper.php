<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        return 'dashboard';
    }
}

// Global helpers file with misc functions.
if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}


if (!function_exists('common')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function common()
    {
        return app('common');
    }
}

if (!function_exists('report_multiple_by_100')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function report_multiple_by_100($value, $isNotRound = 1)
    {
        return $isNotRound ? $value * 100 : round($value * 100);
    }
}

if (!function_exists('permission_redirect')) {
    /**
     * Access (lol) the Access:: facade as a simple function.
     */
    function permission_redirect()
    {
        return redirect()->route('dashboard')->with('error', "You do not have permission!");
    }
}

if (!function_exists('_P')) {
    function _P($data)
    {
        echo "<pre>";
        print_r($data);
        exit;
    }
}

if (!function_exists('FolderExists')) {
    function FolderExists($user_id)
    {
        if (!Storage::exists('/upload/' . $user_id)) {
            return Storage::makeDirectory('/upload/' . $user_id, 0775, true);
        }
        
        return true;
    }
}

if (!function_exists('FileUpload')) {
    /**
     * FileUpload return file name
     */
    function FileUpload($file, $FolderName = 'upload')
    {
        $file->storeAs($FolderName, $file->hashName());
        return $file->hashName();
    }
}
