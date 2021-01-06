<?php

use App\Http\Controllers\AdminResellerController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogActivityController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Reseller\ResellerController;
use App\Http\Controllers\Reseller\CommissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\CommissionController as adminCommision;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Models\Commission;
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
// ApiController

Route::group(['middleware' => ['auth']], function () {
	Route::group(['prefix' => 'admin'], function () {
		
	Route::post('/swithaccount', [CompanyController::class,'switchAccount'])->name('account.switch');
	Route::get('', [HomeController::class, 'index'])->name('admin');
	// search bycompany
	Route::get('/user/{company}', [AdminUserController::class, 'searchByCompany'])->name('admin.user.company');
	Route::get('/reseller/{company}', [AdminResellerController::class, 'searchByCompany'])->name('admin.reseller.company');
	Route::get('/role/{company}', [RoleController::class, 'searchByCompany'])->name('admin.role.company');
	Route::get('/product/{company}', [ProductController::class, 'searchByCompany'])->name('admin.product.company');
	// route resouce
	Route::resource('/company', CompanyController::class, ["as" => "admin"]);
	Route::resource('/user', AdminUserController::class, ["as" => "admin"]);
	Route::resource('/role', RoleController::class, ["as" => "admin"]);
	Route::resource('/product', ProductController::class, ["as" => "admin"]);
	Route::resource('/setting', SettingController::class, ["as" => "admin"]);
	Route::resource('/commissions', adminCommision::class, ["as" => "admin"]);
	Route::resource('/log', LogActivityController::class, ["as" => "admin"]);
	Route::resource('/reseller', AdminResellerController::class, ["as" => "admin"]);
	
	// custom route
	Route::post('/approval', [AdminResellerController::class, 'getApproval'])->name('getApproval');
	Route::post('/approvalCompany', [CompanyController::class, 'approve'])->name('approveCompany');
	Route::get('/status', [AdminResellerController::class, 'getStatus'])->name('getStatus');
	Route::get('/get-city', [AdminResellerController::class, 'getCity']);
	Route::get('/get-city-edit', [AdminResellerController::class, 'getCityEdit']);
	Route::patch('/{product}', [ProductController::class, 'updateCode'])->name('admin.product.updateCode');
});
Route::group(['prefix' => 'reseller'], function () {
	Route::get('', [HomeController::class, 'index'])->name('reseller');
	Route::resource('/client', ClientController::class,["as"=>"reseller"]);
	Route::resource('/commission', CommissionController::class,["as"=>"reseller"]);
	Route::get('/transaction/{client}', [ClientController::class,'searchByClient'],["as"=>"reseller"])->name('reseller.client.search');
	Route::get('/transaction', [ClientController::class,'transaction'],["as"=>"reseller"])->name('reseller.client.transaction');
	Route::get('/commision-month', [CommissionController::class,'getTransactionMonth'],["as"=>"reseller"])->name('reseller.client.transaction-month');
	Route::post('/swithaccount/reseller', [ResellerController::class,'switchAccount'])->name('account.switch.reseller');
});

});



Route::group(['middleware' => 'auth'], function () {
	// Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

});
Route::post('/notification/read', [HomeController::class,'markReadNotify'])->name('notification.read');
Route::post('register/{id}', [ApiController::class, 'RegisterApi']);