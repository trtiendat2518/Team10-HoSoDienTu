<?php

namespace App\Http\Controllers\Student\Notification;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function noti_procedure($student_id)
    {
        $procedure = Notification::join('tbl_procedure_require', 'tbl_procedure_require.procedure_require_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_procedure', 'tbl_procedure.procedure_id', '=', 'tbl_procedure_require.procedure_require_detail')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 3)
            ->where('tbl_notification.notification_type', 'procedure')
            ->where('tbl_notification.notification_student', $student_id)
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($procedure);
    }

    public function noti_request($student_id)
    {
        $procedure = Notification::join('tbl_request', 'tbl_request.request_id', '=', 'tbl_notification.notification_title')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_notification.notification_student')
            ->where('tbl_notification.notification_object', 3)
            ->where('tbl_notification.notification_type', 'request')
            ->where('tbl_notification.notification_student', $student_id)
            ->orderby('tbl_notification.notification_id', 'DESC')->get();
        return NotificationResource::collection($procedure);
    }
}
