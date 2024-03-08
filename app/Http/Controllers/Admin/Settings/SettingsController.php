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
  
    
    public function markupCreate(Request $request)
    {   
        $settingsArr = Setting::where('type','1')->first();
        return view('admin.settings.markup.create', ['model'=>$settingsArr]);
    }

    public function markupStore(Request $request)
    {   
        $this->settingRepository->createMarkup($request->all());
        return redirect()->route('setting-global-markup')->with('success','Global Markup add successfully!');
    }

    public function markupUpdate(Request $request, Setting $setting)
    {        
        
        $this->settingRepository->updateMarkup($request->all(), $setting);
        return redirect()->route('setting-global-markup')->with('success','Global Markup update successfully!');
    }


    public function emailCreate(Request $request)
    {   
        $settingsArr = Setting::where('type','2')->first();
        
        return view('admin.settings.hb-emails.create', ['model'=>$settingsArr]);
    }

    public function emailStore(Request $request)
    {   
        $this->settingRepository->createEmails($request->all());
        return redirect()->route('setting-hb-email')->with('success','HB emails add successfully!');
    }

    public function emailUpdate(Request $request, Setting $setting)
    {        
        
        $this->settingRepository->updateEmails($request->all(), $setting);
        return redirect()->route('setting-hb-email')->with('success','HB emails update successfully!');
    }

}
