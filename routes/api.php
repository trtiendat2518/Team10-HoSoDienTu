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
        Route::post('giang-vien/role/{lecturer}', 'Admin\Users\LecturerManageController@role');
        Route::get('giang-vien/admin/','Admin\Users\LecturerManageController@admin');
        Route::get('giang-vien/lecturer/','Admin\Users\LecturerManageController@lecturer');
        Route::get('giang-vien/detail/{lecturer}','Admin\Users\LecturerManageController@detail');   
        Route::get('giang-vien/search/{query}/{currentEntries}','Admin\Users\LecturerManageController@search');
        Route::get('giang-vien/filter/{value}/{currentEntries}','Admin\Users\LecturerManageController@filter');
        Route::patch('giang-vien/change/{lecturer}', 'Admin\Users\LecturerManageController@change');
        Route::post('giang-vien/destroyall/', 'Admin\Users\LecturerManageController@destroyall');
        Route::resource('giang-vien', 'Admin\Users\LecturerManageController');
    });

    Route::prefix('user-sv')->group(function(){
        Route::get('sinh-vien/studentinfo/','Admin\Users\StudentManageController@studentinfo');
        Route::get('sinh-vien/detail/{student}','Admin\Users\StudentManageController@detail');
        Route::get('sinh-vien/search/{query}/{currentEntries}','Admin\Users\StudentManageController@search');
        Route::get('sinh-vien/filter/{value}/{currentEntries}','Admin\Users\StudentManageController@filter');
        Route::patch('sing-vien/change/{student}', 'Admin\Users\StudentManageController@change');
        Route::post('sinh-vien/destroyall/', 'Admin\Users\StudentManageController@destroyall');
        Route::resource('sinh-vien', 'Admin\Users\StudentManageController');
    });

    Route::prefix('edu-faculty')->group(function(){
        Route::get('khoa/faculty/','Admin\Education\FacultyController@faculty');
        Route::get('khoa/search/{query}/{currentEntries}','Admin\Education\FacultyController@search');
        Route::post('khoa/destroyall/', 'Admin\Education\FacultyController@destroyall');
        Route::patch('khoa/change/{faculty}', 'Admin\Education\FacultyController@change');
        Route::get('khoa/detail/{faculty}','Admin\Education\FacultyController@detail');
        Route::post('khoa/import', 'Admin\Education\FacultyController@import');
        Route::get('khoa/export', 'Admin\Education\FacultyController@export');
        Route::resource('khoa', 'Admin\Education\FacultyController');
    });

    Route::prefix('edu-major')->group(function(){
        Route::get('chuyen-nganh/major/','Admin\Education\MajorController@major');
        Route::patch('chuyen-nganh/change/{major}', 'Admin\Education\MajorController@change');
        Route::get('chuyen-nganh/search/{query}/{currentEntries}','Admin\Education\MajorController@search');
        Route::post('chuyen-nganh/destroyall/', 'Admin\Education\MajorController@destroyall');
        Route::get('chuyen-nganh/filter/{faculty}/{currentEntries}', 'Admin\Education\MajorController@filter');
        Route::get('chuyen-nganh/detail/{major}','Admin\Education\MajorController@detail');
        Route::post('chuyen-nganh/import', 'Admin\Education\MajorController@import');
        Route::get('chuyen-nganh/export', 'Admin\Education\MajorController@export');
        Route::resource('chuyen-nganh', 'Admin\Education\MajorController');
    });

    Route::prefix('edu-course')->group(function(){
        Route::get('khoa-hoc/course','Admin\Education\CourseController@course');
        Route::post('khoa-hoc/import', 'Admin\Education\CourseController@import');
        Route::get('khoa-hoc/export', 'Admin\Education\CourseController@export');
        Route::get('khoa-hoc/detail/{course}','Admin\Education\CourseController@detail');
        Route::patch('khoa-hoc/change/{course}', 'Admin\Education\CourseController@change');
        Route::post('khoa-hoc/destroyall/', 'Admin\Education\CourseController@destroyall');
        Route::get('khoa-hoc/search/{query}/{currentEntries}','Admin\Education\CourseController@search');
        Route::resource('khoa-hoc', 'Admin\Education\CourseController');
    });

    Route::prefix('post-news')->group(function(){
        //Route::get('bai-viet/detail/{post}','Admin\Posts\PostController@detail');
        Route::get('bai-viet/post/{post_id}','Admin\Posts\PostController@post');
        Route::post('bai-viet/destroyall/', 'Admin\Posts\PostController@destroyall');
        Route::get('bai-viet/filter/{admin}/{currentEntries}', 'Admin\Posts\PostController@filter');
        Route::get('bai-viet/search/{query}/{currentEntries}','Admin\Posts\PostController@search');
        Route::patch('bai-viet/change/{post}', 'Admin\Posts\PostController@change');
        Route::resource('bai-viet', 'Admin\Posts\PostController');
    });

    Route::prefix('manage')->group(function(){
        Route::get('mon-hoc/subject', 'Admin\Education\SubjectController@subject');
        Route::post('mon-hoc/import/{faculty}', 'Admin\Education\SubjectController@import');
        Route::get('mon-hoc/export/{faculty}', 'Admin\Education\SubjectController@export');
        Route::get('mon-hoc/filter/{faculty}/{currentEntries}', 'Admin\Education\SubjectController@filter');
        Route::get('mon-hoc/showother/{lecturer_id}/{currentEntries}','Admin\Education\SubjectController@showother');
        Route::get('mon-hoc/showdata/{lecturer_id}/{currentEntries}','Admin\Education\SubjectController@showdata');
        Route::patch('mon-hoc/change/{subject}', 'Admin\Education\SubjectController@change');
        Route::get('mon-hoc/detail/{subject}','Admin\Education\SubjectController@detail');
        Route::post('mon-hoc/destroyall/', 'Admin\Education\SubjectController@destroyall');
        Route::get('mon-hoc/searchother/{faculty}/{query}/{currentEntries}','Admin\Education\SubjectController@searchother');
        Route::get('mon-hoc/search/{faculty}/{query}/{currentEntries}','Admin\Education\SubjectController@search');
        Route::resource('mon-hoc', 'Admin\Education\SubjectController');
    });

    Route::prefix('program')->group(function(){
        Route::post('chuong-trinh-dao-tao/create-subject-program', 'Admin\Education\EducationProgramController@create_subject_program');
        Route::post('chuong-trinh-dao-tao/update-subject-program/{program_detail_id}', 'Admin\Education\EducationProgramController@update_subject_program');
        Route::post('chuong-trinh-dao-tao/import/{program_code}', 'Admin\Education\EducationProgramController@import');
        Route::post('chuong-trinh-dao-tao/destroy-subject-program/{program_detail_id}','Admin\Education\EducationProgramController@destroy_subject_program');
        Route::get('chuong-trinh-dao-tao/detail-subject-program/{program_detail_id}','Admin\Education\EducationProgramController@detail_subject_program');
        Route::get('chuong-trinh-dao-tao/show-subject-program/{education_program_id}','Admin\Education\EducationProgramController@show_subject_program');
        Route::get('chuong-trinh-dao-tao/program-one/{education_program_id}','Admin\Education\EducationProgramController@program_one');
        Route::patch('chuong-trinh-dao-tao/change/{educationProgram}', 'Admin\Education\EducationProgramController@change');
        Route::post('chuong-trinh-dao-tao/destroyall/', 'Admin\Education\EducationProgramController@destroyall');
        Route::get('chuong-trinh-dao-tao/showdata/{lecturer_id}/{currentEntries}','Admin\Education\EducationProgramController@showdata');
        Route::resource('chuong-trinh-dao-tao', 'Admin\Education\EducationProgramController');
    });

    Route::prefix('type')->group(function(){
        Route::get('he-dao-tao/program-type','Admin\Education\ProgramTypeController@program_type');
        Route::patch('he-dao-tao/change/{programType}', 'Admin\Education\ProgramTypeController@change');
        Route::post('he-dao-tao/destroyall/', 'Admin\Education\ProgramTypeController@destroyall');
        Route::get('he-dao-tao/search/{query}/{currentEntries}','Admin\Education\ProgramTypeController@search');
        Route::resource('he-dao-tao', 'Admin\Education\ProgramTypeController');
    });

    Route::prefix('procedure')->group(function() {
        Route::get('thu-tuc/get-all', 'Admin\Posts\ProcedureController@procedure_all');
        Route::get('thu-tuc/filter/{value}/{currentEntries}', 'Admin\Posts\ProcedureController@filter');
        Route::get('thu-tuc/search/{query}/{currentEntries}','Admin\Posts\ProcedureController@search');
        Route::post('thu-tuc/destroyall/', 'Admin\Posts\ProcedureController@destroyall');
        Route::patch('thu-tuc/change/{procedure_id}', 'Admin\Posts\ProcedureController@change');
        Route::get('thu-tuc/procedure-one/{procedure_id}','Admin\Posts\ProcedureController@procedure');
        Route::resource('thu-tuc', 'Admin\Posts\ProcedureController');
    });

    Route::prefix('procedure-require')->group(function() {
        Route::get('yeu-cau-thu-tuc/filter/{value}/{currentEntries}', 'Admin\Posts\ProcedureRequireController@filter');
        Route::get('yeu-cau-thu-tuc/search/{query}/{currentEntries}','Admin\Posts\ProcedureRequireController@search');
        Route::patch('yeu-cau-thu-tuc/change/{procedure_require_id}', 'Admin\Posts\ProcedureRequireController@change');
        Route::resource('yeu-cau-thu-tuc', 'Admin\Posts\ProcedureRequireController');
    });

    Route::prefix('user-cn')->group(function() {
        Route::get('chu-nhiem-sinh-vien/detail/{form_teacher_id}','Admin\Users\FormTeacherController@detail');
        // Route::get('chu-nhiem-sinh-vien/filter/{lecturer_id}/{value}/{currentEntries}','Admin\Users\FormTeacherController@filter');
        Route::get('chu-nhiem-sinh-vien/search/{lecturer_id}/{query}/{currentEntries}','Admin\Users\FormTeacherController@search');
        Route::get('chu-nhiem-sinh-vien/showdata/{lecturer_id}/{currentEntries}','Admin\Users\FormTeacherController@showdata');
        Route::resource('chu-nhiem-sinh-vien', 'Admin\Users\FormTeacherController');
    });

    Route::prefix('class-sv')->group(function() {
        Route::get('lop/class-student/{lecturer_id}','Admin\Education\ClassStudentController@classstudent');
    });
});