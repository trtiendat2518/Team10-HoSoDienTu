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
    Route::get('/dashboard', 'Lecturer\AuthController@index')->middleware('checkloged');

    Route::get('/login', 'Lecturer\AuthController@get_login')->middleware('checkss');
    Route::post('/loged-in', 'Lecturer\AuthController@post_login');
    Route::get('/logout', 'Lecturer\AuthController@get_logout');

    Route::get('/microsoft','Lecturer\AuthController@login_ms')->name('connectMs');
    Route::get('/microsoft-callback','Lecturer\AuthController@callback_ms');
});
