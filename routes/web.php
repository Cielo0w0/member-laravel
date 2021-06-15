<?php

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


// Route::post('/admin/news', 'NewsController@index');
// Route::post('/admin/product', 'NewsController@index');

// // 把admin群組起來
// Route::prefix('admin')->group(function(){
//     Route::get('/news', 'NewsController@index');
//     Route::get('/product', 'NewsController@index');
// });

// 要  登入狀態(=Auth)  &   同時是管理者     ->    才可以用admin群組裡的東西
Route::middleware(['auth','can:admin'])->prefix('admin')->group(function(){
    Route::get('/news', 'NewsController@index');
    Route::get('/product', 'NewsController@index');
});




// Auth::routes();
// =
// Authentication Routes...
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

// Password Reset Routes...
Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
Route::post('password/reset', 'Auth\ResetPasswordController@reset');

Route::get('/home', 'HomeController@index')->name('home');
