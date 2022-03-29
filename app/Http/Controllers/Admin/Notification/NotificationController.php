<?php

namespace App\Http\Controllers\Admin\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Lecturer;
use App\Models\Major;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function show($notification)
    {
        $find = Notification::find($notification);
        $detail = Notification::join('tbl_procedure_require', 'tbl_procedure_require.procedure_require_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->where('tbl_procedure_require.procedure_require_student', $find->notification_student)
            ->where('tbl_notification.notification_object', 0)
            ->where('tbl_notification.notification_id', $notification)
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($detail);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function edit(Notification $notification)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $notification)
    {
        $noti = Notification::find($notification);
        $noti->notification_status = 1;
        $noti->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Notification  $notification
     * @return \Illuminate\Http\Response
     */
    public function destroy($notification)
    {
        $noti = Notification::find($notification);
        $noti->delete();
    }

    function notification_small_formteacher($lecturer_id)
    {
        $joins = Notification::join('tbl_request', 'tbl_request.request_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_class.class_form_teacher')
            ->where('tbl_notification.notification_object', 2)
            ->where('tbl_notification.notification_type', 'request')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->orderby('tbl_notification.notification_id', 'DESC')->limit(5)->get();
        return NotificationResource::collection($joins);
    }

    function notification_large_formteacher($lecturer_id)
    {
        $joins = Notification::join('tbl_request', 'tbl_request.request_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_class.class_form_teacher')
            ->where('tbl_notification.notification_object', 2)
            ->where('tbl_notification.notification_type', 'request')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($joins);
    }

    function notification_noneread_formteacher($lecturer_id)
    {
        $joins = Notification::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_class.class_form_teacher')
            ->where('tbl_notification.notification_object', 2)
            ->where('tbl_notification.notification_type', 'request')
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->where('tbl_notification.notification_status', 0)->get();
        return NotificationResource::collection($joins);
    }

    public function read_all_formteacher($lecturer_id)
    {
        $noneRead = Notification::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_class.class_form_teacher')
            ->where('notification_object', 2)
            ->where('notification_status', 0)
            ->where('tbl_lecturer.lecturer_id', $lecturer_id)
            ->where('tbl_notification.notification_type', 'request')->get();

        foreach ($noneRead as $key => $value) {
            $value->notification_status = 1;
            $value->save();
        }
    }

    function notification_small_admin()
    {
        $joins = Notification::join('tbl_procedure_require', 'tbl_procedure_require.procedure_require_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 0)
            ->where('tbl_notification.notification_type', 'procedure')
            ->orderby('tbl_notification.notification_id', 'DESC')->limit(5)->get();
        return NotificationResource::collection($joins);
    }

    function notification_large_admin()
    {
        $joins = Notification::join('tbl_procedure_require', 'tbl_procedure_require.procedure_require_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 0)
            ->where('tbl_notification.notification_type', 'procedure')
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($joins);
    }

    function notification_noneread_admin()
    {
        $joins = Notification::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 0)
            ->where('tbl_notification.notification_type', 'procedure')
            ->where('tbl_notification.notification_status', 0)->get();
        return NotificationResource::collection($joins);
    }

    public function read_all_admin()
    {
        $noneRead = Notification::where('notification_object', 0)
            ->where('notification_status', 0)
            ->where('tbl_notification.notification_type', 'procedure')->get();

        foreach ($noneRead as $key => $value) {
            $value->notification_status = 1;
            $value->save();
        }
    }

    function notification_small_lecturer()
    {
        $joins = Notification::join('tbl_exam_second', 'tbl_exam_second.exam_second_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_exam_second.exam_second_subject')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 1)
            ->where('tbl_notification.notification_type', 'subject')
            ->orderby('tbl_notification.notification_id', 'DESC')->limit(5)->get();
        return NotificationResource::collection($joins);
    }

    function notification_large_lecturer()
    {
        $joins = Notification::join('tbl_exam_second', 'tbl_exam_second.exam_second_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_exam_second.exam_second_subject')
            ->join('tbl_major', 'tbl_major.major_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 1)
            ->where('tbl_notification.notification_type', 'subject')
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($joins);
    }

    function notification_noneread_lecturer($lecturer_id)
    {
        $find = Lecturer::find($lecturer_id);
        $joins = Notification::join('tbl_major', 'tbl_major.major_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_major.major_faculty')
            ->where('tbl_notification.notification_object', 1)
            ->where('tbl_notification.notification_type', 'subject')
            ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
            ->where('tbl_notification.notification_status', 0)->get();
        return NotificationResource::collection($joins);
    }

    public function read_all_lecturer($lecturer_id)
    {
        $find = Lecturer::find($lecturer_id);
        $noneRead = Notification::join('tbl_major', 'tbl_major.major_id', '=', 'tbl_notification.notification_student')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_major.major_faculty')
            ->where('notification_object', 1)
            ->where('notification_status', 0)
            ->where('tbl_faculty.faculty_id', $find->lecturer_faculty)
            ->where('tbl_notification.notification_type', 'subject')->get();

        foreach ($noneRead as $key => $value) {
            $value->notification_status = 1;
            $value->save();
        }
    }
}
