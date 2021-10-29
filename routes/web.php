<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', function () {
    return menu('backend-sidebar');
});
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['as' => 'login.', 'prefix' => 'login'], function () {
    Route::get('/{provider}', [LoginController::class, 'redirectToProvider'])->name('provider');
    Route::get('/{provider}/callback', [LoginController::class, 'handleProviderCallback'])->name('callback');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Pages route e.g. [about,contact,etc]
Route::get('/{slug}', [PageController::class, 'show'])->name('page');
