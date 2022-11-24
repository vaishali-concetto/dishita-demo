<?php

use App\Http\Controllers\ProfileController;
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

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

/*Route::get('/', function () {
    return view('welcome');
});*/
\Illuminate\Support\Facades\Auth::routes();
//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/admin',[LoginController::class,'showAdminLoginForm'])->name('admin.login-view');
Route::post('/admin',[LoginController::class,'adminLogin'])->name('admin.login');
Route::get('admin/logout',[LoginController::class,'adminLogout'])->name('admin.logout');
Route::get('/admin/register',[RegisterController::class,'showAdminRegisterForm'])->name('admin.register-view');
Route::post('/admin/register',[RegisterController::class,'createAdmin'])->name('admin.register');
Route::get('/admin/dashboard', [\App\Http\Controllers\HomeController::class, 'AdminDashboard'])->middleware('auth');


Route::get('/customer',[LoginController::class,'showCustomerLoginForm'])->name('customer.login-view');
Route::post('/customer',[LoginController::class,'customerLogin'])->name('customer.login');
Route::get('customer/logout',[LoginController::class,'customerLogout'])->name('customer.logout');
Route::get('/customer/register',[RegisterController::class,'showCustomerRegisterForm'])->name('customer.register-view');
Route::post('/customer/register',[RegisterController::class,'createCustomer'])->name('customer.register');
Route::get('/customer/dashboard',  [\App\Http\Controllers\HomeController::class, 'CustomerDashboard'])->middleware('auth');


Route::get('/seller',[LoginController::class,'showSellerLoginForm'])->name('seller.login-view');
Route::post('/seller',[LoginController::class,'sellerLogin'])->name('seller.login');
Route::get('seller/logout',[LoginController::class,'sellerLogout'])->name('seller.logout');
Route::get('/seller/register',[RegisterController::class,'showSellerRegisterForm'])->name('seller.register-view');
Route::post('/seller/register',[RegisterController::class,'createSeller'])->name('seller.register');
Route::group(['middleware' => ['auth'], 'prefix' => 'seller'], function (){
    Route::get('dashboard', [\App\Http\Controllers\HomeController::class, 'SellerDashboard']);
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('brands', \App\Http\Controllers\BrandController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::post('sub_categories', [\App\Http\Controllers\ProductController::class, 'sub_categories']);
});


Route::get('home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('product_detail/{id}', [\App\Http\Controllers\HomeController::class, 'product_detail'])->name('product_detail');
