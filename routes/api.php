<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->group(function(){
    Route::prefix('quan-ly-tai-khoan')->group(function(){
        //Giang Vien
        Route::get('giang-vien/detail/{lecturer}','Admin\Users\LecturerManageController@detail')->name('giang-vien.detail');   
        Route::get('giang-vien/search/{query}/{currentEntries}','Admin\Users\LecturerManageController@search')->name('giang-vien.search');
        Route::patch('giang-vien/change/{lecturer}', 'Admin\Users\LecturerManageController@change')->name('giang-vien.change');
        Route::post('giang-vien/destroyall/', 'Admin\Users\LecturerManageController@destroyall')->name('giang-vien.destroyall/{lecturer}');
        Route::resource('giang-vien', 'Admin\Users\LecturerManageController');
        
        //Sinh vien
        Route::resource('sinh-vien', 'Admin\Users\StudentManageController');
        Route::resource('thong-tin-giang-vien', 'Admin\Users\LecturerInfoController');
    });
});