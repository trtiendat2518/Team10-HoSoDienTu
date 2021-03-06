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

Route::prefix('admin')->group(function () {
    Route::prefix('user-gv')->group(function () {
        Route::get('giang-vien/alllecturer', 'Admin\Users\LecturerManageController@alllecturer');
        Route::post('giang-vien/cap-nhat-thong-tin-ca-nhan-bcnk-noimg/{info_id}', 'Admin\Users\LecturerManageController@update_info_deanfaculty_noimg');
        Route::post('giang-vien/cap-nhat-thong-tin-ca-nhan-bcnk/{info_id}', 'Admin\Users\LecturerManageController@update_info_deanfaculty');
        Route::post('giang-vien/tao-thong-tin-ca-nhan-bcnk', 'Admin\Users\LecturerManageController@create_info_deanfaculty');
        Route::get('giang-vien/thong-tin-ca-nhan-bcnk/{lecturer_id}', 'Admin\Users\LecturerManageController@info_deanfaculty');
        Route::get('giang-vien/bcnk/{lecturer_id}', 'Admin\Users\LecturerManageController@deanfaculty');

        Route::post('giang-vien/cap-nhat-thong-tin-ca-nhan-noimg/{info_id}', 'Admin\Users\LecturerManageController@update_info_admin_noimg');
        Route::post('giang-vien/cap-nhat-thong-tin-ca-nhan/{info_id}', 'Admin\Users\LecturerManageController@update_info_admin');
        Route::post('giang-vien/tao-thong-tin-ca-nhan', 'Admin\Users\LecturerManageController@create_info_admin');
        Route::get('giang-vien/thong-tin-ca-nhan/{admin_id}', 'Admin\Users\LecturerManageController@info_admin');

        Route::get('giang-vien/search-formteacher/{lecturer_id}/{query}/{currentEntries}', 'Admin\Users\LecturerManageController@search_formteacher');
        Route::get('giang-vien/show-formteacher/{lecturer_id}/{currentEntries}', 'Admin\Users\LecturerManageController@show_formteacher');
        Route::get('giang-vien/formteacher/{lecturer_id}', 'Admin\Users\LecturerManageController@formteacher');

        Route::get('giang-vien/admin/', 'Admin\Users\LecturerManageController@admin');
        Route::get('giang-vien/lecturer/', 'Admin\Users\LecturerManageController@lecturer');
        Route::get('giang-vien/detail/{lecturer}', 'Admin\Users\LecturerManageController@detail');
        Route::get('giang-vien/search/{query}/{currentEntries}', 'Admin\Users\LecturerManageController@search');
        Route::get('giang-vien/filter/{value}/{currentEntries}', 'Admin\Users\LecturerManageController@filter');
        Route::patch('giang-vien/change/{lecturer}', 'Admin\Users\LecturerManageController@change');
        Route::post('giang-vien/destroyall/', 'Admin\Users\LecturerManageController@destroyall');
        Route::resource('giang-vien', 'Admin\Users\LecturerManageController');
    });

    Route::prefix('user-sv')->group(function () {
        Route::get('sinh-vien/chua-co-thong-tin/{student_id}', 'Admin\Users\StudentManageController@nonedetail');
        Route::post('sinh-vien/cap-nhat-thong-tin/{student_id}', 'Admin\Users\StudentManageController@update_info_personal');
        Route::get('sinh-vien/course-major/{course}/{major}', 'Admin\Users\StudentManageController@student_course_major');
        Route::get('sinh-vien/student-form-teacher/{lecturer_id}', 'Admin\Users\StudentManageController@student_form_teacher');
        Route::get('sinh-vien/allstudent', 'Admin\Users\StudentManageController@allstudent');
        Route::post('sinh-vien/import', 'Admin\Users\StudentManageController@import');
        Route::post('sinh-vien/upgrade/{student}', 'Admin\Users\StudentManageController@upgrade');
        Route::patch('sinh-vien/patch/{student}', 'Admin\Users\StudentManageController@patch');
        Route::get('sinh-vien/studentinfo/', 'Admin\Users\StudentManageController@studentinfo');
        Route::get('sinh-vien/detail/{student}', 'Admin\Users\StudentManageController@detail');
        Route::get('sinh-vien/search/{query}/{currentEntries}', 'Admin\Users\StudentManageController@search');
        Route::get('sinh-vien/filter/{value}/{currentEntries}', 'Admin\Users\StudentManageController@filter');
        Route::patch('sing-vien/change/{student}', 'Admin\Users\StudentManageController@change');
        Route::post('sinh-vien/destroyall/', 'Admin\Users\StudentManageController@destroyall');
        Route::resource('sinh-vien', 'Admin\Users\StudentManageController');
    });

    Route::prefix('edu-faculty')->group(function () {
        Route::get('khoa/faculty/', 'Admin\Education\FacultyController@faculty');
        Route::get('khoa/search/{query}/{currentEntries}', 'Admin\Education\FacultyController@search');
        Route::post('khoa/destroyall/', 'Admin\Education\FacultyController@destroyall');
        Route::patch('khoa/change/{faculty}', 'Admin\Education\FacultyController@change');
        Route::get('khoa/detail/{faculty}', 'Admin\Education\FacultyController@detail');
        Route::post('khoa/import', 'Admin\Education\FacultyController@import');
        Route::get('khoa/export', 'Admin\Education\FacultyController@export');
        Route::resource('khoa', 'Admin\Education\FacultyController');
    });

    Route::prefix('edu-major')->group(function () {
        Route::get('chuyen-nganh/major-faculty/{faculty_id}', 'Admin\Education\MajorController@major_faculty');
        Route::get('chuyen-nganh/lecturer_major/{lecturer_id}', 'Admin\Education\MajorController@lecturer_major');
        Route::get('chuyen-nganh/major/', 'Admin\Education\MajorController@major');
        Route::patch('chuyen-nganh/change/{major}', 'Admin\Education\MajorController@change');
        Route::get('chuyen-nganh/search/{query}/{currentEntries}', 'Admin\Education\MajorController@search');
        Route::post('chuyen-nganh/destroyall/', 'Admin\Education\MajorController@destroyall');
        Route::get('chuyen-nganh/filter/{faculty}/{currentEntries}', 'Admin\Education\MajorController@filter');
        Route::get('chuyen-nganh/detail/{major}', 'Admin\Education\MajorController@detail');
        Route::post('chuyen-nganh/import', 'Admin\Education\MajorController@import');
        Route::get('chuyen-nganh/export', 'Admin\Education\MajorController@export');
        Route::resource('chuyen-nganh', 'Admin\Education\MajorController');
    });

    Route::prefix('edu-course')->group(function () {
        Route::get('khoa-hoc/course', 'Admin\Education\CourseController@course');
        Route::post('khoa-hoc/import', 'Admin\Education\CourseController@import');
        Route::get('khoa-hoc/export', 'Admin\Education\CourseController@export');
        Route::get('khoa-hoc/detail/{course}', 'Admin\Education\CourseController@detail');
        Route::patch('khoa-hoc/change/{course}', 'Admin\Education\CourseController@change');
        Route::post('khoa-hoc/destroyall/', 'Admin\Education\CourseController@destroyall');
        Route::get('khoa-hoc/search/{query}/{currentEntries}', 'Admin\Education\CourseController@search');
        Route::resource('khoa-hoc', 'Admin\Education\CourseController');
    });

    Route::prefix('post-news')->group(function () {
        Route::post('bai-viet/update-file/{post}', 'Admin\Posts\PostController@update_file');
        Route::get('bai-viet/post-news-all', 'Admin\Posts\PostController@post_news_all');
        Route::get('bai-viet/post-notification-all', 'Admin\Posts\PostController@post_notification_all');
        Route::get('bai-viet/post-news', 'Admin\Posts\PostController@post_news');
        Route::get('bai-viet/post-notification', 'Admin\Posts\PostController@post_notification');
        Route::get('bai-viet/post/{post_id}', 'Admin\Posts\PostController@post');
        Route::post('bai-viet/destroyall/', 'Admin\Posts\PostController@destroyall');
        Route::get('bai-viet/filter/{admin}/{currentEntries}', 'Admin\Posts\PostController@filter');
        Route::get('bai-viet/search/{query}/{currentEntries}', 'Admin\Posts\PostController@search');
        Route::patch('bai-viet/change/{post}', 'Admin\Posts\PostController@change');
        Route::resource('bai-viet', 'Admin\Posts\PostController');
    });

    Route::prefix('manage')->group(function () {
        Route::get('mon-hoc/subject', 'Admin\Education\SubjectController@subject');
        Route::post('mon-hoc/import/{faculty}', 'Admin\Education\SubjectController@import');
        Route::get('mon-hoc/export/{faculty}', 'Admin\Education\SubjectController@export');
        Route::get('mon-hoc/filter/{faculty}/{currentEntries}', 'Admin\Education\SubjectController@filter');
        Route::get('mon-hoc/showother/{lecturer_id}/{currentEntries}', 'Admin\Education\SubjectController@showother');
        Route::get('mon-hoc/showdata/{lecturer_id}/{currentEntries}', 'Admin\Education\SubjectController@showdata');
        Route::patch('mon-hoc/change/{subject}', 'Admin\Education\SubjectController@change');
        Route::get('mon-hoc/detail/{subject}', 'Admin\Education\SubjectController@detail');
        Route::post('mon-hoc/destroyall/', 'Admin\Education\SubjectController@destroyall');
        Route::get('mon-hoc/searchother/{faculty}/{query}/{currentEntries}', 'Admin\Education\SubjectController@searchother');
        Route::get('mon-hoc/search/{faculty}/{query}/{currentEntries}', 'Admin\Education\SubjectController@search');
        Route::resource('mon-hoc', 'Admin\Education\SubjectController');
    });

    Route::prefix('program')->group(function () {
        Route::get('chuong-trinh-dao-tao/tao-lich-bieu/{course}/{lecturer_id}/{semester}', 'Admin\Education\EducationProgramController@education_program_calendar');
        Route::get('chuong-trinh-dao-tao/theo-khoa-hoc/{course}/{lecturer_id}', 'Admin\Education\EducationProgramController@education_program_lecturer');
        Route::post('chuong-trinh-dao-tao/create-subject-program', 'Admin\Education\EducationProgramController@create_subject_program');
        Route::post('chuong-trinh-dao-tao/update-subject-program/{program_detail_id}', 'Admin\Education\EducationProgramController@update_subject_program');
        Route::post('chuong-trinh-dao-tao/import/{program_code}', 'Admin\Education\EducationProgramController@import');
        Route::post('chuong-trinh-dao-tao/destroy-subject-program/{program_detail_id}', 'Admin\Education\EducationProgramController@destroy_subject_program');
        Route::get('chuong-trinh-dao-tao/detail-subject-program/{program_detail_id}', 'Admin\Education\EducationProgramController@detail_subject_program');
        Route::get('chuong-trinh-dao-tao/show-subject-program/{education_program_id}', 'Admin\Education\EducationProgramController@show_subject_program');
        Route::get('chuong-trinh-dao-tao/program-one/{education_program_id}', 'Admin\Education\EducationProgramController@program_one');
        Route::patch('chuong-trinh-dao-tao/change/{educationProgram}', 'Admin\Education\EducationProgramController@change');
        Route::post('chuong-trinh-dao-tao/destroyall/', 'Admin\Education\EducationProgramController@destroyall');
        Route::get('chuong-trinh-dao-tao/showdata/{lecturer_id}/{currentEntries}', 'Admin\Education\EducationProgramController@showdata');
        Route::resource('chuong-trinh-dao-tao', 'Admin\Education\EducationProgramController');
    });

    Route::prefix('type')->group(function () {
        Route::get('he-dao-tao/program-type', 'Admin\Education\ProgramTypeController@program_type');
        Route::patch('he-dao-tao/change/{programType}', 'Admin\Education\ProgramTypeController@change');
        Route::post('he-dao-tao/destroyall/', 'Admin\Education\ProgramTypeController@destroyall');
        Route::get('he-dao-tao/search/{query}/{currentEntries}', 'Admin\Education\ProgramTypeController@search');
        Route::resource('he-dao-tao', 'Admin\Education\ProgramTypeController');
    });

    Route::prefix('procedure')->group(function () {
        Route::get('thu-tuc/get-all', 'Admin\Posts\ProcedureController@procedure_all');
        Route::get('thu-tuc/filter/{value}/{currentEntries}', 'Admin\Posts\ProcedureController@filter');
        Route::get('thu-tuc/search/{query}/{currentEntries}', 'Admin\Posts\ProcedureController@search');
        Route::post('thu-tuc/destroyall/', 'Admin\Posts\ProcedureController@destroyall');
        Route::patch('thu-tuc/change/{procedure_id}', 'Admin\Posts\ProcedureController@change');
        Route::get('thu-tuc/procedure-one/{procedure_id}', 'Admin\Posts\ProcedureController@procedure');
        Route::resource('thu-tuc', 'Admin\Posts\ProcedureController');
    });

    Route::prefix('procedure-require')->group(function () {
        Route::get('yeu-cau-thu-tuc/detail/{procedure_require_id}', 'Admin\Posts\ProcedureRequireController@detail');
        Route::get('yeu-cau-thu-tuc/filter/{value}/{currentEntries}', 'Admin\Posts\ProcedureRequireController@filter');
        Route::get('yeu-cau-thu-tuc/search/{query}/{currentEntries}', 'Admin\Posts\ProcedureRequireController@search');
        Route::post('yeu-cau-thu-tuc/change/{procedure_require_id}/{admin_id}', 'Admin\Posts\ProcedureRequireController@change');
        Route::resource('yeu-cau-thu-tuc', 'Admin\Posts\ProcedureRequireController');
    });

    Route::prefix('class-sv')->group(function () {
        Route::get('lop/class-formteacher/{lecturer_id}', 'Admin\Education\ClassStudentController@formteacher_class');
        Route::get('lop/teacher-student-class/{class}', 'Admin\Education\ClassStudentController@teacher_student_class');
        Route::get('lop/search-student-class/{class}/{query}', 'Admin\Education\ClassStudentController@search_student_class');
        Route::get('lop/student-class/{class}', 'Admin\Education\ClassStudentController@student_class');
        Route::post('lop/destroyall/', 'Admin\Education\ClassStudentController@destroyall');
        Route::patch('lop/change/{class}', 'Admin\Education\ClassStudentController@change');
        Route::get('lop/filter/{faculty}/{value}/{currentEntries}', 'Admin\Education\ClassStudentController@filter');
        Route::get('lop/search/{faculty}/{query}/{currentEntries}', 'Admin\Education\ClassStudentController@search');
        Route::get('lop/class-student/{lecturer_id}', 'Admin\Education\ClassStudentController@classstudent');
        Route::get('lop/all-class', 'Admin\Education\ClassStudentController@allclass');
        Route::get('lop/showdata/{lecturer_id}/{currentEntries}', 'Admin\Education\ClassStudentController@showdata');
        Route::resource('lop', 'Admin\Education\ClassStudentController');
    });

    Route::prefix('calendar-schedule')->group(function () {
        Route::get('lich-bieu/send-mail/{course}/{major}/{semester}/{category}', 'Admin\Calendar\CalendarController@send_mail');
        Route::get('lich-bieu/except-calendar/{calendar_id}', 'Admin\Calendar\CalendarController@except_calendar');
        Route::get('lich-bieu/chuong-trinh-dao-tao/{course}/{major}/{semester}', 'Admin\Calendar\CalendarController@get_programs');
        Route::get('lich-bieu/hoc-ky/{course}/{major}', 'Admin\Calendar\CalendarController@get_semester');
        Route::post('lich-bieu/update-plan/{calendar_id}', 'Admin\Calendar\CalendarController@update_plan');
        Route::get('lich-bieu/subject-plan/{calendar_id}', 'Admin\Calendar\CalendarController@subject_for_plan');
        Route::get('lich-bieu/schedule-paytuition', 'Admin\Calendar\CalendarController@schedule_paytuition');
        Route::get('lich-bieu/schedule-subject', 'Admin\Calendar\CalendarController@schedule_subject');
        Route::get('lich-bieu/schedule-exam', 'Admin\Calendar\CalendarController@schedule_exam');
        Route::get('lich-bieu/schedule', 'Admin\Calendar\CalendarController@schedule');
        Route::resource('lich-bieu', 'Admin\Calendar\CalendarController');
    });

    Route::prefix('calendar-exam')->group(function () {
        Route::get('lich-thi/sinh-vien/{student_id}', 'Admin\Calendar\CalendarExamController@calendar_student_exam');
        Route::get('lich-thi/detail/{calendar_exam_id}', 'Admin\Calendar\CalendarExamController@detail');
        Route::get('lich-thi/search/{query}/{currentEntries}', 'Admin\Calendar\CalendarExamController@search');
        Route::resource('lich-thi', 'Admin\Calendar\CalendarExamController');
    });

    Route::prefix('exam-second')->group(function () {
        Route::get('dang-ky-thi-lan-2/search-data/{lecturer_id}/{query}/{currentEntries}', 'Admin\Calendar\ExamSecondController@searchdata');
        Route::get('dang-ky-thi-lan-2/show-data/{lecturer_id}/{currentEntries}', 'Admin\Calendar\ExamSecondController@showdata');
        Route::post('dang-ky-thi-lan-2/huy-bo/{student_id}/{subject_id}', 'Admin\Calendar\ExamSecondController@cancel_subject_student');
        Route::get('dang-ky-thi-lan-2/sinh-vien/{student_id}', 'Admin\Calendar\ExamSecondController@show_subject_student');
        Route::resource('dang-ky-thi-lan-2', 'Admin\Calendar\ExamSecondController');
    });

    Route::prefix('calendar-subject')->group(function () {
        Route::get('lich-mo-lop-hoc/filter-in-calendar/{course_id}/{major_id}/{semester}', 'Admin\Calendar\CalendarSubjectController@filter_incalendar');
        Route::get('lich-mo-lop-hoc/filter/{course_id}/{major_id}/{semester}/{currentEntries}', 'Admin\Calendar\CalendarSubjectController@filter');
        Route::patch('lich-mo-lop-hoc/change/{calendar_subject_id}', 'Admin\Calendar\CalendarSubjectController@change');
        Route::get('lich-mo-lop-hoc/show-subjects/{id}', 'Admin\Calendar\CalendarSubjectController@show_subject');
        Route::get('lich-mo-lop-hoc/detail/{calendar_subject_id}', 'Admin\Calendar\CalendarSubjectController@detail');
        Route::get('lich-mo-lop-hoc/search/{query}/{currentEntries}', 'Admin\Calendar\CalendarSubjectController@search');
        Route::resource('lich-mo-lop-hoc', 'Admin\Calendar\CalendarSubjectController');
    });

    Route::prefix('edu-program-sv')->group(function () {
        Route::get('chuong-trinh-dao-tao-sinh-vien/filter/{value}', 'Admin\Education\EducationProgramStudentController@filter');
        Route::resource('chuong-trinh-dao-tao-sinh-vien', 'Admin\Education\EducationProgramStudentController');
    });

    Route::prefix('request-sv')->group(function () {
        Route::get('yeu-cau-sinh-vien/detail/{request_id}', 'Admin\Posts\RequestStudentController@detail');
        Route::post('yeu-cau-sinh-vien/destroyall/', 'Admin\Posts\RequestStudentController@destroyall');
        Route::get('yeu-cau-sinh-vien/filter/{lecturer_id}/{value}/{currentEntries}', 'Admin\Posts\RequestStudentController@filter');
        Route::get('yeu-cau-sinh-vien/search/{lecturer_id}/{query}/{currentEntries}', 'Admin\Posts\RequestStudentController@search');
        Route::put('yeu-cau-sinh-vien/reject/{lecturer_id}', 'Admin\Posts\RequestStudentController@reject');
        Route::patch('yeu-cau-sinh-vien/accept/{lecturer_id}', 'Admin\Posts\RequestStudentController@accept');
        Route::get('yeu-cau-sinh-vien/showdata/{lecturer_id}/{currentEntries}', 'Admin\Posts\RequestStudentController@showdata');
        Route::resource('yeu-cau-sinh-vien', 'Admin\Posts\RequestStudentController');
    });

    Route::prefix('register-subject')->group(function () {
        Route::get('dang-ky-mon-hoc-sv/export/{course}/{major}/{semester}', 'Admin\Education\RegisterSubjectController@statistic_export');
        Route::get('dang-ky-mon-hoc-sv/so-luong-lop-it/{course}/{major}/{semester}', 'Admin\Education\RegisterSubjectController@statistic_subject_slot');
        Route::get('dang-ky-mon-hoc-sv/da-dang-ky/{course}/{major}/{semester}', 'Admin\Education\RegisterSubjectController@statistic_student_registered');
        Route::post('dang-ky-mon-hoc-sv/import/{student_id}', 'Admin\Education\RegisterSubjectController@import');
        Route::get('dang-ky-mon-hoc-sv/xem-thi-lan-2/{student_id}', 'Admin\Education\RegisterSubjectController@exam_second');
        Route::get('dang-ky-mon-hoc-sv/xem-diem/{student_id}', 'Admin\Education\RegisterSubjectController@score');
        Route::resource('dang-ky-mon-hoc-sv', 'Admin\Education\RegisterSubjectController');
    });

    Route::prefix('register-plan')->group(function () {
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/export/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_export');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/tong-so-mon-ke-hoach/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_subject_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-xem-loai/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_detail_type');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-goi-y-tat-ca/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_plan_suggestall');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-goi-y-ca-nhan/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_plan_suggestonly');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky-ca-nhan/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_plan_mine');
        Route::get('dang-ky-ke-hoach-hoc-tap-sv/da-dang-ky/{course}/{major}/{semester}', 'Admin\Education\RegisterPlanController@statistic_student_plan');
        Route::resource('dang-ky-ke-hoach-hoc-tap-sv', 'Admin\Education\RegisterPlanController');
    });

    Route::prefix('suggest-plan')->group(function () {
        Route::get('goi-y-ke-hoach-hoc-tap-sv/detail/{plan_suggest_id}', 'Admin\Education\PlanSuggestController@detail');
        Route::post('goi-y-ke-hoach-hoc-tap-sv/destroyall', 'Admin\Education\PlanSuggestController@destroyall');
        Route::post('goi-y-ke-hoach-hoc-tap-sv/upgrade/{plan_suggest_id}', 'Admin\Education\PlanSuggestController@upgrade');
        Route::get('goi-y-ke-hoach-hoc-tap-sv/onlyone/{plan_suggest_id}', 'Admin\Education\PlanSuggestController@onlyone');
        Route::patch('goi-y-ke-hoach-hoc-tap-sv/change/{plan_suggest_id}', 'Admin\Education\PlanSuggestController@change');
        Route::get('goi-y-ke-hoach-hoc-tap-sv/search/{lecturer_id}/{query}/{currentEntries}', 'Admin\Education\PlanSuggestController@search');
        Route::get('goi-y-ke-hoach-hoc-tap-sv/{lecturer_id}/{currentEntries}', 'Admin\Education\PlanSuggestController@showdata');
        Route::resource('goi-y-ke-hoach-hoc-tap-sv', 'Admin\Education\PlanSuggestController');
    });

    Route::prefix('statistic')->group(function () {
        Route::get('thong-ke-truy-cap/thang-truoc', 'Admin\AuthController@sum_lastmonth');
        Route::get('thong-ke-truy-cap/thang-nay', 'Admin\AuthController@sum_thismonth');
        Route::get('thong-ke-truy-cap/mot-nam', 'Admin\AuthController@sum_year');
        Route::get('thong-ke-truy-cap/tat-ca', 'Admin\AuthController@sum_visitor');
    });

    Route::prefix('notification')->group(function () {
        Route::post('thong-bao/bcn-khoa/doc-tat-ca/{lecturer_id}', 'Admin\Notification\NotificationController@read_all_lecturer');
        Route::get('thong-bao/bcn-khoa/chua-doc/{lecturer_id}', 'Admin\Notification\NotificationController@notification_noneread_lecturer');
        Route::get('thong-bao/bcn-khoa/tat-ca', 'Admin\Notification\NotificationController@notification_large_lecturer');
        Route::get('thong-bao/bcn-khoa', 'Admin\Notification\NotificationController@notification_small_lecturer');
        Route::post('thong-bao/gvcn/doc-tat-ca/{lecturer_id}', 'Admin\Notification\NotificationController@read_all_formteacher');
        Route::get('thong-bao/gvcn/chua-doc/{lecturer_id}', 'Admin\Notification\NotificationController@notification_noneread_formteacher');
        Route::get('thong-bao/gvcn/tat-ca/{lecturer_id}', 'Admin\Notification\NotificationController@notification_large_formteacher');
        Route::get('thong-bao/gvcn/{lecturer_id}', 'Admin\Notification\NotificationController@notification_small_formteacher');
        Route::post('thong-bao/quan-tri-vien/doc-tat-ca', 'Admin\Notification\NotificationController@read_all_admin');
        Route::get('thong-bao/quan-tri-vien/chua-doc', 'Admin\Notification\NotificationController@notification_noneread_admin');
        Route::get('thong-bao/quan-tri-vien/tat-ca', 'Admin\Notification\NotificationController@notification_large_admin');
        Route::get('thong-bao/quan-tri-vien', 'Admin\Notification\NotificationController@notification_small_admin');
        Route::resource('thong-bao', 'Admin\Notification\NotificationController');
    });

    Route::prefix('tuition-management')->group(function () {
        Route::get('quan-ly-hoc-phi/filter-course-faculty-major/{course_id}/{faculty_id}/{major_id}/{currentEntries}', 'Admin\Tuition\TuitionController@filter_course_faculty_major');
        Route::get('quan-ly-hoc-phi/filter-course-faculty/{course_id}/{faculty_id}/{currentEntries}', 'Admin\Tuition\TuitionController@filter_course_faculty');
        Route::get('quan-ly-hoc-phi/filter-course/{course_id}/{currentEntries}', 'Admin\Tuition\TuitionController@filter_course');
        Route::post('quan-ly-hoc-phi/destroyall', 'Admin\Tuition\TuitionController@destroyall');
        Route::get('quan-ly-hoc-phi/not-in/{tuition_id}', 'Admin\Tuition\TuitionController@not_in');
        Route::resource('quan-ly-hoc-phi', 'Admin\Tuition\TuitionController');
    });
});

Route::prefix('student')->group(function () {
    Route::prefix('study-plan')->group(function () {
        Route::get('dang-ky-ke-hoach-hoc-tap/subject-again-1/{student_id}', 'Student\Registration\StudyPlanController@subject_again_1');
        Route::post('dang-ky-ke-hoach-hoc-tap/cancel-register-again/{subject_id}', 'Student\Registration\StudyPlanController@cancel_plan_again');
        Route::post('dang-ky-ke-hoach-hoc-tap/register-again', 'Student\Registration\StudyPlanController@plan_again');
        Route::get('dang-ky-ke-hoach-hoc-tap/learn-again/{student_id}', 'Student\Registration\StudyPlanController@learn_again');
        Route::get('dang-ky-ke-hoach-hoc-tap/subject-fail-plan/{id}', 'Student\Registration\StudyPlanController@subject_fail_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap/subject-plan/{student_id}/{semester}', 'Student\Registration\StudyPlanController@subject_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap/send-mail/{student_id}/{semester}', 'Student\Registration\StudyPlanController@send_mail');
        Route::get('dang-ky-ke-hoach-hoc-tap/filter/{student_id}/{value}', 'Student\Registration\StudyPlanController@filter');
        Route::get('dang-ky-ke-hoach-hoc-tap/my-all-plan/{student_id}', 'Student\Registration\StudyPlanController@my_all_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap/my-plan-again/{student_id}/{semester}', 'Student\Registration\StudyPlanController@my_plan_again');
        Route::get('dang-ky-ke-hoach-hoc-tap/my-plan/{student_id}/{semester}', 'Student\Registration\StudyPlanController@my_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap/thoi-gian-dang-ky/{student_id}', 'Student\Registration\StudyPlanController@calendar_timeplan');
        Route::get('dang-ky-ke-hoach-hoc-tap/lich-ke-hoach/{student_id}', 'Student\Registration\StudyPlanController@calendar_plan');
        Route::get('dang-ky-ke-hoach-hoc-tap/goi-y-ca-nhan/{student_id}', 'Student\Registration\StudyPlanController@show_suggest_only');
        Route::get('dang-ky-ke-hoach-hoc-tap/goi-y-ca-lop/{student_id}', 'Student\Registration\StudyPlanController@show_suggest_all');
        Route::get('dang-ky-ke-hoach-hoc-tap/score/{student_id}', 'Student\Registration\StudyPlanController@showdata');
        Route::resource('dang-ky-ke-hoach-hoc-tap', 'Student\Registration\StudyPlanController');
    });

    Route::prefix('subject-register')->group(function () {
        Route::get('dang-ky-mon-hoc/learn-again/{student_id}', 'Student\Registration\SubjectController@learn_again');
        Route::get('dang-ky-mon-hoc/my-all-subject/{student_id}', 'Student\Registration\SubjectController@my_all_subject');
        Route::get('dang-ky-mon-hoc/subject-fail/{student_id}', 'Student\Registration\SubjectController@subject_fail');
        Route::get('dang-ky-mon-hoc/send-mail/{student_id}/{semester}', 'Student\Registration\SubjectController@send_mail');
        Route::post('dang-ky-mon-hoc/thay-doi-mon-hoc/{calendar_subject_id}/{register_subject_id}', 'Student\Registration\SubjectController@change_subject');
        Route::post('dang-ky-mon-hoc/huy-mon-hoc/{calendar_subject_id}/{register_subject_id}', 'Student\Registration\SubjectController@cancel_subject');
        Route::get('dang-ky-mon-hoc/ket-qua-dk-tat-ca/{student_id}/{semester}', 'Student\Registration\SubjectController@result_all');
        Route::get('dang-ky-mon-hoc/ket-qua-dk-con/{student_id}/{semester}/{subject_id}', 'Student\Registration\SubjectController@result_register_subject');
        Route::get('dang-ky-mon-hoc/chon-lop-mon-hoc-hoc-lai/{student_id}/{calendar_id}/{subject_id}', 'Student\Registration\SubjectController@register_subject_again');
        Route::get('dang-ky-mon-hoc/chon-lop-mon-hoc/{student_id}/{semester}/{subject_id}', 'Student\Registration\SubjectController@register_subject');
        Route::get('dang-ky-mon-hoc/so-luong-lop-mon-hoc-hoc-lai/{student_id}/{calendar_id}', 'Student\Registration\SubjectController@quantity_again');
        Route::get('dang-ky-mon-hoc/so-luong-lop-mon-hoc/{student_id}/{semester}', 'Student\Registration\SubjectController@quantity');
        Route::get('dang-ky-mon-hoc/ngoai-ke-hoach/{student_id}/{semester}', 'Student\Registration\SubjectController@show_subject_outplan');
        Route::get('dang-ky-mon-hoc/theo-ke-hoach-hoc-lai/{student_id}/{semester}', 'Student\Registration\SubjectController@show_subject_inplan_again');
        Route::get('dang-ky-mon-hoc/theo-ke-hoach/{student_id}/{semester}', 'Student\Registration\SubjectController@show_subject_inplan');
        Route::get('dang-ky-mon-hoc/theo-ctdt/{student_id}/{semester}', 'Student\Registration\SubjectController@show_subject_program');
        Route::get('dang-ky-mon-hoc/thoi-gian-dang-ky/{student_id}', 'Student\Registration\SubjectController@calendar_time_register');
        Route::resource('dang-ky-mon-hoc', 'Student\Registration\SubjectController');
    });

    Route::prefix('train-point')->group(function () {
        Route::get('danh-gia-diem-ren-luyen/bcn-khoa-danh-gia/{student_id}/{semester}', 'Student\Registration\TrainPointController@get_point_deanfaculty');
        Route::get('danh-gia-diem-ren-luyen/chu-nhiem-danh-gia/{student_id}/{semester}', 'Student\Registration\TrainPointController@get_point_formteacher');
        Route::get('danh-gia-diem-ren-luyen/tu-danh-gia/{student_id}/{semester}', 'Student\Registration\TrainPointController@get_point_ttudent');
        Route::get('danh-gia-diem-ren-luyen/thoi-gian-danh-gia-khoa/{student_id}', 'Student\Registration\TrainPointController@calendar_timefaculty_trainpoint');
        Route::get('danh-gia-diem-ren-luyen/thoi-gian-danh-gia-chu-nhiem/{student_id}', 'Student\Registration\TrainPointController@calendar_timeformteacher_trainpoint');
        Route::get('danh-gia-diem-ren-luyen/thoi-gian-danh-gia-sinh-vien/{student_id}', 'Student\Registration\TrainPointController@calendar_timestudent_trainpoint');
        Route::resource('danh-gia-diem-ren-luyen', 'Student\Registration\TrainPointController');
    });

    Route::prefix('request-to-ft')->group(function () {
        Route::post('gui-yeu-cau/updatedata/{request_id}', 'Student\Post\RequestController@update_data');
        Route::post('gui-yeu-cau/updatefile/{request_id}', 'Student\Post\RequestController@update_file');
        Route::post('gui-yeu-cau/file', 'Student\Post\RequestController@store_file');
        Route::get('gui-yeu-cau/search/{student_id}/{query}/{currentEntries}', 'Student\Post\RequestController@search');
        Route::get('gui-yeu-cau/filter/{student_id}/{value}/{currentEntries}', 'Student\Post\RequestController@filter');
        Route::get('gui-yeu-cau/showdata/{student_id}/{currentEntries}', 'Student\Post\RequestController@showdata');
        Route::resource('gui-yeu-cau', 'Student\Post\RequestController');
    });

    Route::prefix('procedure')->group(function () {
        Route::get('yeu-cau-thuc-tuc-sv/my-procedures/{student_id}', 'Student\Post\ProcedureController@my_procedures');
        Route::resource('yeu-cau-thuc-tuc-sv', 'Student\Post\ProcedureController');
    });

    Route::prefix('notification')->group(function () {
        // Route::post('thong-bao/quan-tri-vien/doc-tat-ca', 'Admin\Notification\NotificationController@read_all_admin');
        // Route::get('thong-bao/quan-tri-vien/chua-doc', 'Admin\Notification\NotificationController@notification_noneread_admin');
        // Route::get('thong-bao/quan-tri-vien/tat-ca', 'Admin\Notification\NotificationController@notification_large_admin');
        // Route::get('thong-bao/quan-tri-vien', 'Admin\Notification\NotificationController@notification_small_admin');
        Route::get('thong-bao/yeu-cau/{student_id}', 'Student\Notification\NotificationController@noti_request');
        Route::get('thong-bao/thu-tuc/{student_id}', 'Student\Notification\NotificationController@noti_procedure');
        Route::resource('thong-bao', 'Student\Notification\NotificationController');
    });

    Route::prefix('pay-tuition')->group(function () {
        Route::get('thanh-toan-hoc-phi/detail-payment/{payment_id}', 'Student\Registration\PayTuitionController@detail_payment');
        Route::get('thanh-toan-hoc-phi/total-payment/{student_id}', 'Student\Registration\PayTuitionController@total_payment');
        Route::get('thanh-toan-hoc-phi/check-payment/{student_id}/{semester}', 'Student\Registration\PayTuitionController@check_payment');
        Route::post('thanh-toan-hoc-phi/momo/{student_id}/{semester}', 'Student\Registration\PayTuitionController@momo_paytuition');
        Route::post('thanh-toan-hoc-phi/vnpay/{student_id}/{semester}', 'Student\Registration\PayTuitionController@vnpay_paytuition');
        Route::get('thanh-toan-hoc-phi/mon-hoc/{student_id}/{semester}', 'Student\Registration\PayTuitionController@subject_paytuition');
        Route::get('thanh-toan-hoc-phi/thoi-gian-thanh-toan/{student_id}', 'Student\Registration\PayTuitionController@calendar_paytuition');
        Route::resource('thanh-toan-hoc-phi', 'Student\Registration\PayTuitionController');
    });
});
