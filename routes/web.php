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
    return view('student.pages.home');
});

Route::prefix('admin')->group(function(){
    Route::resource('', 'Admin\DashboardController')->only('index')->middleware('checkloged');

    Route::get('/login', 'Admin\AuthController@get_login')->middleware('checkss');
    Route::post('/loged-in', 'Admin\AuthController@post_login');
    Route::get('/logout', 'Admin\AuthController@get_logout');

    Route::get('/microsoft','Admin\AuthController@login_ms')->name('connectMs');
    Route::get('/microsoft-callback','Admin\AuthController@callback_ms');
});

