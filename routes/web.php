<?php

use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Reseller\ResellerController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/konfirmasiemail/{email}/{ref_code}', [App\Http\Controllers\Auth\RegisterController::class, 'konfirmasiemail'])->name('konfirmasiemail');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
Route::get('/admin', [HomeController::class, 'index'])->name('admin')->middleware('auth');
Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user')->middleware('auth');
Route::delete('/admin/{user}', [AdminUserController::class, 'destroy'])->middleware('auth');
Route::get('/admin/{user}/edit', [AdminUserController::class, 'edit']);
Route::patch('/admin/{user}', [AdminUserController::class, 'update'])->middleware('auth');

Route::resource('/admin/product', ProductController::class);
Route::resource('/admin/setting', SettingController::class);

Route::get('/reseller', [ResellerController::class, 'index'])->name('reseller');



// Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('auth');


// Route::group(['middleware' => 'auth'], function () {
// 	Route::get('table-list', function () {
// 		return view('pages.table_list');
// 	})->name('table');

// 	Route::get('typography', function () {
// 		return view('pages.typography');
// 	})->name('typography');

// 	Route::get('icons', function () {
// 		return view('pages.icons');
// 	})->name('icons');

// 	Route::get('map', function () {
// 		return view('pages.map');
// 	})->name('map');

// 	Route::get('notifications', function () {
// 		return view('pages.notifications');
// 	})->name('notifications');

// 	Route::get('rtl-support', function () {
// 		return view('pages.language');
// 	})->name('language');

// 	Route::get('upgrade', function () {
// 		return view('pages.upgrade');
// 	})->name('upgrade');
// });

Route::group(['middleware' => 'auth'], function () {
	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});

Route::group(['middleware' => 'auth'], function() {
	// Route::res
});

