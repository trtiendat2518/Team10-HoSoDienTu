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
        Route::get('giang-vien/detail/{lecturer}','Admin\Users\LecturerManageController@detail');   
        Route::get('giang-vien/search/{query}/{currentEntries}','Admin\Users\LecturerManageController@search');
        Route::get('giang-vien/filter/{value}/{currentEntries}','Admin\Users\LecturerManageController@filter');
        Route::patch('giang-vien/change/{lecturer}', 'Admin\Users\LecturerManageController@change');
        Route::post('giang-vien/destroyall/', 'Admin\Users\LecturerManageController@destroyall');
        Route::resource('giang-vien', 'Admin\Users\LecturerManageController');
    });

    Route::prefix('user-sv')->group(function(){
        //Sinh vien
        Route::get('sinh-vien/detail/{student}','Admin\Users\StudentManageController@detail');
        Route::get('sinh-vien/search/{query}/{currentEntries}','Admin\Users\StudentManageController@search');
        Route::get('sinh-vien/filter/{value}/{currentEntries}','Admin\Users\StudentManageController@filter');
        Route::patch('sing-vien/change/{student}', 'Admin\Users\StudentManageController@change');
        Route::post('sinh-vien/destroyall/', 'Admin\Users\StudentManageController@destroyall');
        Route::resource('sinh-vien', 'Admin\Users\StudentManageController');
    });

    Route::prefix('edu-faculty')->group(function(){
        Route::get('khoa/search/{query}/{currentEntries}','Admin\Education\FacultyController@search');
        Route::post('khoa/destroyall/', 'Admin\Education\FacultyController@destroyall');
        Route::patch('khoa/change/{faculty}', 'Admin\Education\FacultyController@change');
        Route::get('khoa/detail/{faculty}','Admin\Education\FacultyController@detail');
        Route::post('khoa/import', 'Admin\Education\FacultyController@import');
        Route::get('khoa/export', 'Admin\Education\FacultyController@export');
        Route::resource('khoa', 'Admin\Education\FacultyController');
    });

    Route::prefix('edu-major')->group(function(){
        Route::patch('chuyen-nganh/change/{major}', 'Admin\Education\MajorController@change');
        Route::get('chuyen-nganh/faculty/','Admin\Education\MajorController@faculty');
        Route::get('chuyen-nganh/search/{query}/{currentEntries}','Admin\Education\MajorController@search');
        Route::post('chuyen-nganh/destroyall/', 'Admin\Education\MajorController@destroyall');
        Route::get('chuyen-nganh/filter/{faculty}/{currentEntries}', 'Admin\Education\MajorController@filter');
        Route::get('chuyen-nganh/detail/{major}','Admin\Education\MajorController@detail');
        Route::post('chuyen-nganh/import', 'Admin\Education\MajorController@import');
        Route::get('chuyen-nganh/export', 'Admin\Education\MajorController@export');
        Route::resource('chuyen-nganh', 'Admin\Education\MajorController');
    });

    Route::prefix('edu-course')->group(function(){
        Route::get('khoa-hoc/search/{query}/{currentEntries}','Admin\Education\CourseController@search');
        Route::resource('khoa-hoc', 'Admin\Education\CourseController');
    });
});