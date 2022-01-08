<?php

namespace App\Http\Controllers\Admin\Posts;

use App\Http\Controllers\Controller;
use App\Models\RequestSudent;
use Illuminate\Http\Request;
use App\Http\Resources\RequestResource;

class RequestStudentController extends Controller
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
     * @param  \App\Models\RequestSudent  $requestSudent
     * @return \Illuminate\Http\Response
     */
    public function show(RequestSudent $requestSudent)
    {
        //
    }

    public function showdata($lecturer_id, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_class.class_form_teacher', $lecturer_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function search($lecturer_id, $query, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_student.student_fullname', 'LIKE', '%' . $query . '%')
            ->where('tbl_class.class_form_teacher', $lecturer_id)
            ->orwhere('tbl_student.student_code', 'LIKE', '%' . $query . '%')
            ->where('tbl_class.class_form_teacher', $lecturer_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestSudent  $requestSudent
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestSudent $requestSudent)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestSudent  $requestSudent
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $requestSudent)
    {
        $find = RequestSudent::find($requestSudent);
        $find->request_reply = $request->request_reply;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $find->updated_at = now();
        $find->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestSudent  $requestSudent
     * @return \Illuminate\Http\Response
     */
    public function destroy($requestSudent)
    {
        $find = RequestSudent::find($requestSudent);
        $find->delete();
    }

    public function accept(Request $request, $requestSudent)
    {
        $req = RequestSudent::find($requestSudent);
        $req->request_status = $request->request_status;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $req->updated_at = now();
        $req->save();
    }

    public function reject(Request $request, $requestSudent)
    {
        $req = RequestSudent::find($requestSudent);
        $req->request_reply = $request->request_reply;
        $req->request_status = $request->request_status;
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $req->updated_at = now();
        $req->save();
    }

    public function filter($lecturer_id, $value, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_request.request_status', $value)
            ->where('tbl_class.class_form_teacher', $lecturer_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function destroyall(Request $request, $req = null)
    {
        if ($request->req) {
            foreach ($request->req as $id) {
                RequestSudent::where('request_id', $id)->delete();
            }
        }
    }

    public function detail($request_id)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_request.request_id', $request_id)
            ->get();
        return RequestResource::collection($joins);
    }
}
