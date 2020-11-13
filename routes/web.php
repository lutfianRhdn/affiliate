<?php

use App\Helpers\LogActivity;
use App\Http\Controllers\AdminResellerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ApiController;
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

Route::get('/registration', [RegisterController::class, 'index'])->name('registration');
Route::get('/registration/get-city', [RegisterController::class, 'getCity']);
// Route::get('/registration/create', [RegisterController::class, 'create'])->name('registration.create');
// Route::get('/registration', [RegisterController::class, 'store'])->name('registrations.store');
Route::get('/confirmation/{email}', [App\Http\Controllers\Auth\RegisterController::class, 'emailConfirmation'])->name('emailConfirmation');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
// ApiController
Route::post('register/{id}', [ApiController::class, 'RegisterApi']);

Route::group(['middleware' => ['auth'],'prefix'=>'admin'], function () {
	Route::get('', [HomeController::class, 'index'])->name('admin');
	// Route::get('/user', [AdminUserController::class, 'index'])->name('admin.user')->middleware('auth');
	// Route::get('/user/create', [AdminUserController::class, 'create']);
	// Route::delete('/{user}', [AdminUserController::class, 'destroy'])->middleware('auth');
	// Route::get('/{user}/edit', [AdminUserController::class, 'edit']);
	// Route::patch('/{user}', [AdminUserController::class, 'update'])->middleware('auth');

// route resouce
	Route::resource('/user', AdminUserController::class, ["as" => "admin"]);
	Route::resource('/role', RoleController::class, ["as" => "admin"]);
	Route::resource('/product', ProductController::class, ["as" => "admin"]);
	Route::resource('/setting', SettingController::class, ["as" => "admin"]);
	Route::resource('/log', LogActivityController::class, ["as" => "admin"]);

// custom route
	Route::post('/approval', [AdminResellerController::class, 'getApproval'])->name('getApproval');
	Route::get('/status', [AdminResellerController::class, 'getStatus'])->name('getStatus');
	Route::resource('/reseller', AdminResellerController::class, ["as" => "admin"]);
	Route::get('/get-city', [AdminResellerController::class, 'getCity']);
	Route::get('/get-city-edit', [AdminResellerController::class, 'getCityEdit']);
	Route::patch('/{product}', [ProductController::class, 'updateCode'])->name('admin.product.updateCode');
});

// reseller route
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


