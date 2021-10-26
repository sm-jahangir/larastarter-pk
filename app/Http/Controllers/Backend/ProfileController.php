<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        Gate::authorize('app.profile.update');
        return view('backend.profile.index');
    }
    public function update(Request $request)
    {
        $this->validate($request, [
            'name'  =>  'required|string|max:255',
            'email' =>  'required|string|max:255|unique:users,email,' . Auth::id(),
            'avatar'    =>  'nullable|image',
        ]);
        // return $request;
        // Get logged in user
        $user = Auth::user();
        // Update user info
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        // upload images
        if ($request->hasFile('avatar')) {
            $user->addMedia($request->avatar)->toMediaCollection('avatar');
        }
        // return with success msg
        notify()->success('Profile Successfully Updated.', 'Updated');
        return redirect()->back();
    }
    
    public function changePassword()
    {
        Gate::authorize('app.profile.password');
        return view('backend.profile.security');
    }

    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'current_password'  =>  'required|string|max:255',
            'password'  =>  'required|confirmed',
        ]);
        
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->current_password, $hashedPassword)) {
            if (!Hash::check($request->password, $hashedPassword)) {
                Auth::user()->update([
                    'password' => Hash::make($request->password)
                ]);
                Auth::logout();
                notify()->success('Password Successfully Changed.', 'Success');
                return redirect()->route('login');
            } else {
                notify()->warning('New password cannot be the same as old password.', 'Warning');
            }
        } else {
            notify()->error('Current password not match.', 'Error');
        }
        return redirect()->back();
    }
}
