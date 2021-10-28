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
        return "Hello world";
    }
}
