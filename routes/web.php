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

Route::get('/admin/dashboard', 'Lecturer\AuthController@index')->middleware('checkloged');

Route::prefix('admin')->group(function(){
    Route::get('/login', 'Lecturer\AuthController@get_login')->middleware('checkss');
    Route::post('/loged-in', 'Lecturer\AuthController@post_login');
    Route::get('/logout', 'Lecturer\AuthController@get_logout');
});
