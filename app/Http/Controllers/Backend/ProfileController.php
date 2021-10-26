<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

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
}
