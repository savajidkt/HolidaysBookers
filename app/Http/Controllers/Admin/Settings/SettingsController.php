<?php

namespace App\Http\Controllers\Admin\Settings;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\EditRequest;
use App\Models\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    protected $settingRepository;
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository       = $settingRepository;
    }

    public function index(Request $request)
    {
        $settingsArr = Setting::where('type','0')->first();
        return view('admin.settings.emails.create',['model'=>$settingsArr]);       
    }

    public function store(Request $request)
    {          
        $this->settingRepository->create($request->all());
        return redirect()->route('settings.index')->with('success', "Settings created successfully!");
    }

    public function update(Request $request, Setting $setting)
    {   
        
        $this->settingRepository->update($request->all(), $setting);
        return redirect()->route('settings.index')->with('success', "Settings updated successfully!");
    }    
}
