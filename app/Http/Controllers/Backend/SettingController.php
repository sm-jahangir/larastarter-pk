<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function general()
    {
        return view('backend.settings.general');
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'site_title'    =>  'required|max:255|min:2|string',
            'site_description'    =>  'nullable|max:255|min:2|string',
            'site_address'    =>  'nullable|max:255|min:2|string',
        ]);
        Setting::updateOrCreate(['name' => 'site_title'], ['value' => $request->get('site_title')]);
        // Update .env file
        Artisan::call("env:set APP_NAME='". $request->site_title ."'");
        notify()->success('Settings Successfully Updated.','Success');
        Setting::updateOrCreate(['name' => 'site_description'], ['value' => $request->get('site_description')]);
        Setting::updateOrCreate(['name' => 'site_address'], ['value' => $request->get('site_address')]);
        return back();
    }
    public function appearance()
    {
        return view('backend.settings.appearance');
    }
    public function updateAppearance(Request $request)
    {
        $this->validate($request, [
            'site_logo'    =>  'nullable|image',
            'site_favicon'    =>  'nullable|image',
        ]);
        // Update Logo
        if ($request->hasFile('site_logo')) {
            $this->deleteOldLogo(setting('site_logo'));
            Setting::updateOrCreate(
                ['name' => 'site_logo'],
                [
                    'value' => Storage::disk('public')->putFile('logos', $request->file('site_logo')),
                ]
            );
        }
        // Update Favicon
        if ($request->hasFile('site_favicon')) {
            $this->deleteOldLogo(setting('site_favicon'));
            Setting::updateOrCreate(
                ['name' => 'site_favicon'],
                [
                    'value' => Storage::disk('public')->putFile('logos', $request->file('site_favicon')),
                ]
            );
        }

        // if ($request->hasFile('site_logo')) {
        //     $this->deleteOldLogo(config('settings.site_logo'));
        //     Setting::set('site_logo',Storage::disk('public')->putFile('logos', $request->file('site_logo')));
        // }
        // if ($request->hasFile('site_favicon')) {
        //     $this->deleteOldLogo(config('settings.site_favicon'));
        //     Setting::set('site_favicon', Storage::disk('public')->putFile('logos', $request->file('site_favicon')));
        // }
        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }
    
    private function deleteOldLogo($path)
    {
        Storage::disk('public')->delete($path);
    }
}
