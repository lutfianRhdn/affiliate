<?php

use App\Helpers\LogActivity;
use App\Http\Controllers\AdminResellerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Reseller\ResellerController;
use App\Http\Controllers\RoleController;
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

Route::get('/registration', [RegisterController::class, 'index']);
Route::get('/registration/get-city', [RegisterController::class, 'getCity']);
// Route::get('/registration/create', [RegisterController::class, 'create'])->name('registration.create');
// Route::get('/registration', [RegisterController::class, 'store'])->name('registrations.store');
Route::get('/confirmation/{email}/{ref_code}', [App\Http\Controllers\Auth\RegisterController::class, 'emailConfirmation'])->name('emailConfirmation');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
Route::group(['middleware' => ['auth','role:admin']], function () {
	Route::get('/admin', [HomeController::class, 'index'])->name('admin');
	// Route::get('/admin/user', [AdminUserController::class, 'index'])->name('admin.user')->middleware('auth');
	// Route::get('/admin/user/create', [AdminUserController::class, 'create']);
	// Route::delete('/admin/{user}', [AdminUserController::class, 'destroy'])->middleware('auth');
	// Route::get('/admin/{user}/edit', [AdminUserController::class, 'edit']);
	// Route::patch('/admin/{user}', [AdminUserController::class, 'update'])->middleware('auth');
	Route::resource('/admin/user', AdminUserController::class, ["as" => "admin"]);
	Route::post('/admin/approval', [AdminResellerController::class, 'getApproval'])->name('getApproval');
	Route::get('/admin/status', [AdminResellerController::class, 'getStatus'])->name('getStatus');
	Route::resource('/admin/reseller', AdminResellerController::class, ["as" => "admin"]);
	Route::resource('/admin/role', RoleController::class, ["as" => "admin"]);
	Route::resource('/admin/product', ProductController::class, ["as" => "admin"]);
	Route::patch('/admin/{product}', [ProductController::class, 'updateCode'])->name('admin.product.updateCode');
	Route::resource('/admin/setting', SettingController::class, ["as" => "admin"]);
	Route::resource('/admin/log', LogActivityController::class, ["as" => "admin"]);
});

Route::group(['middleware' => ['auth','role:reseller']], function () {
	Route::get('/reseller', [ResellerController::class, 'index'])->name('reseller');
});



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
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});


