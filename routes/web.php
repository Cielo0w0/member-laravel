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

Route::get('contact_us', function () {
    return view('/front/contact_us/index');
});

// Route::post('/admin/news', 'NewsController@index');
// Route::post('/admin/product', 'NewsController@index');

// // 把admin群組起來
// Route::prefix('admin')->group(function(){
//     Route::get('/news', 'NewsController@index');
//     Route::get('/product', 'NewsController@index');
// });

// 要  登入狀態(=Auth)  &   同時是管理者     ->    才可以用admin群組裡的東西
Route::middleware(['auth', 'admin'])->prefix('/admin')->group(function () {
    Route::get('/home', 'HomeController@index')->name('home');

    Route::prefix('/news')->group(function () {
        Route::get('/', 'NewsController@index');
        Route::get('/create', 'NewsController@create');
        Route::post('/store', 'NewsController@store');
        Route::get('/edit/{id}', 'NewsController@edit');
        Route::post('/update/{id}', 'NewsController@update');
        Route::delete('/delete/{id}', 'NewsController@delete');
    });


    Route::prefix('/product')->group(function () {
        // 產品管理
        Route::prefix('/type')->group(function () {
            // 產品種類管理
            Route::get('/', 'ProductTypeController@index');
            Route::get('/create', 'ProductTypeController@create');
            Route::post('/store', 'ProductTypeController@store');
            Route::get('/edit/{id}', 'ProductTypeController@edit');
            Route::post('/update/{id}', 'ProductTypeController@update');
            Route::delete('/delete/{id}', 'ProductTypeController@delete');
        });


        Route::prefix('/item')->group(function () {
            // 產品品項管理
            Route::get('/', 'ProductController@index');
            Route::get('/create', 'ProductController@create');
            Route::post('/store', 'ProductController@store');
            Route::get('/edit/{id}', 'ProductController@edit');
            Route::post('/update/{id}', 'ProductController@update');
            Route::delete('/delete/{id}', 'ProductController@delete');
            Route::post('/deleteImage', 'ProductController@deleteImage');
        });
    });


    Route::get('/user', 'UserController@index');
    Route::get('/user/create', 'UserController@create');
    Route::post('/user/store', 'UserController@store');
    Route::get('/user/edit/{id}', 'UserController@edit');
    Route::post('/user/update/{id}', 'UserController@update');
    Route::delete('/user/delete/{id}', 'UserController@delete');
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
