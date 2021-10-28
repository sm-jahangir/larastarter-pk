<?php

namespace App\Http\Controllers\Backend;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;

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
}
