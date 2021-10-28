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

    public function mail()
    {
        return view('backend.settings.mail');
    }
    public function updateMailSettings(Request $request)
    {
        $this->validate($request, [
            'mail_mailer' => 'required|max:255',
            'mail_host' => 'nullable|max:255',
            'mail_port' => 'nullable|max:255',
            'mail_username' => 'nullable|email|max:255',
            'mail_password' => 'nullable|max:255',
            'mail_encryption' => 'nullable|max:255',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name' => 'nullable|max:255',
        ]);
        Setting::updateOrCreate(['name' => 'mail_mailer'], ['value' => $request->get('mail_mailer')]);
        Setting::updateOrCreate(['name' => 'mail_host'], ['value' => $request->get('mail_host')]);
        Setting::updateOrCreate(['name' => 'mail_port'], ['value' => $request->get('mail_port')]);
        Setting::updateOrCreate(['name' => 'mail_username'], ['value' => $request->get('mail_username')]);
        Setting::updateOrCreate(['name' => 'mail_password'], ['value' => $request->get('mail_password')]);
        Setting::updateOrCreate(['name' => 'mail_encryption'], ['value' => $request->get('mail_encryption')]);
        Setting::updateOrCreate(['name' => 'mail_from_address'], ['value' => $request->get('mail_from_address')]);
        Setting::updateOrCreate(['name' => 'mail_from_name'], ['value' => $request->get('mail_from_name')]);

        // Update .env mail settings
        Artisan::call("env:set MAIL_MAILER='". $request->mail_mailer ."'");
        Artisan::call("env:set MAIL_HOST='". $request->mail_host ."'");
        Artisan::call("env:set MAIL_PORT='". $request->mail_port ."'");
        Artisan::call("env:set MAIL_USERNAME='". $request->mail_username ."'");
        Artisan::call("env:set MAIL_PASSWORD='". $request->mail_password ."'");
        Artisan::call("env:set MAIL_ENCRYPTION='". $request->mail_encryption ."'");
        Artisan::call("env:set MAIL_FROM_ADDRESS='". $request->mail_from_address ."'");
        Artisan::call("env:set MAIL_FROM_NAME='". $request->mail_from_name ."'");
        notify()->success('Settings Successfully Updated.','Success');
        return back();
    }
}
