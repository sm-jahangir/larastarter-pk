<?php

namespace App\Http\Controllers\Backend;

use App\Models\Menu;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Gate::authorize('app.menus.index');
        $menus = Menu::latest('id')->get();
        return  view('backend.menus.index',compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Gate::authorize('app.menus.create');
        return view('backend.menus.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Menu::create([
            'name' => Str::slug($request->name),
            'description' => $request->description,
            'deletable' => true
        ]);
        notify()->success('Menu Successfully Added.', 'Added');
        return redirect()->route('app.menus.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Menu $menu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        Gate::authorize('app.menus.edit');
        return view('backend.menus.form',compact('menu'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
        $this->validate($request, [
            'name' =>  'required|string|unique:menus,name,'.$menu->id,
            'description' =>  'nullable|string'
        ]);
        $menu->update([
            'name' => Str::slug($request->name),
            'description' => $request->description,
        ]);
        notify()->success('Menu Successfully Updated.', 'Updated');
        return redirect()->route('app.menus.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        Gate::authorize('app.menus.destroy');
        if ($menu->deletable == true)
        {
            $menu->delete();
            notify()->success('Menu Successfully Deleted.', 'Deleted');
        } else  {
            notify()->error('Sorry you can\'t delete system menu.', 'Error');
        }
        return redirect()->back();
    }
}
