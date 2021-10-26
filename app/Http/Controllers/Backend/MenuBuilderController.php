<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class MenuBuilderController extends Controller
{
    public function index($id)
    {
        Gate::authorize('app.menus.index');
        $menu= Menu::findOrFail($id);
        return view('backend.menus.builder', compact('menu'));
    }
}
