<?php

namespace App\Http\Controllers\Admin\Language;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Config;

//use Illuminate\Support\Facades\App as FacadesApp;

class LocalizationController extends Controller
{
    public function index()
    {
        return view('welcome');
    }
    public function lang_change(Request $request)
    {
        // App::setLocale($request->lang);
        // session()->put('locale', $request->lang);
        if (array_key_exists($request->lang, Config::get('languages'))) {
            Session::put('locale',$request->lang);
        }
        return redirect()->back();
    }
}
