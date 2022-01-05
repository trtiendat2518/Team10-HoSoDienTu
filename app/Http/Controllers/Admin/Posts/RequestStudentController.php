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
            ->where('tbl_class.class_form_teacher', $lecturer_id)
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
    public function update(Request $request, RequestSudent $requestSudent)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestSudent  $requestSudent
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestSudent $requestSudent)
    {
        //
    }
}
