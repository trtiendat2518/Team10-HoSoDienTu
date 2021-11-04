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
    Route::prefix('user-gv')->group(function(){
        //Giang Vien
        Route::get('giang-vien/detail/{lecturer}','Admin\Users\LecturerManageController@detail')->name('giang-vien.detail');   
        Route::get('giang-vien/search/{query}/{currentEntries}','Admin\Users\LecturerManageController@search')->name('giang-vien.search');
        Route::get('giang-vien/filter/{value}/{currentEntries}','Admin\Users\LecturerManageController@filter')->name('giang-vien.filter');
        Route::patch('giang-vien/change/{lecturer}', 'Admin\Users\LecturerManageController@change')->name('giang-vien.change');
        Route::post('giang-vien/destroyall/', 'Admin\Users\LecturerManageController@destroyall')->name('giang-vien.destroyall/{lecturer}');
        Route::resource('giang-vien', 'Admin\Users\LecturerManageController');
    });

    Route::prefix('user-sv')->group(function(){
        //Sinh vien
        Route::get('sinh-vien/detail/{student}','Admin\Users\StudentManageController@detail')->name('sinh-vien.detail');
        Route::get('sinh-vien/search/{query}/{currentEntries}','Admin\Users\StudentManageController@search')->name('sinh-vien.search');
        Route::get('sinh-vien/filter/{value}/{currentEntries}','Admin\Users\StudentManageController@filter')->name('sinh-vien.filter');
        Route::patch('sing-vien/change/{student}', 'Admin\Users\StudentManageController@change')->name('sinh-vien.change');
        Route::post('sinh-vien/destroyall/', 'Admin\Users\StudentManageController@destroyall')->name('sinh-vien.destroyall/{student}');
        Route::resource('sinh-vien', 'Admin\Users\StudentManageController');
    });

    Route::prefix('edu-faculty')->group(function(){
        Route::get('khoa/search/{query}/{currentEntries}','Admin\Education\FacultyController@search');
        Route::resource('khoa', 'Admin\Education\FacultyController');
    });
});