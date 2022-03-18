<?php

namespace App\Http\Controllers\Student\Post;

use App\Http\Controllers\Controller;
use App\Http\Resources\RequestResource;
use App\Models\RequestSudent;
use Illuminate\Http\Request;

class RequestController extends Controller
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

    public function showdata($student_id, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function filter($student_id, $value, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_request.request_status', $value)
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }

    public function search($student_id, $query, $currentEntries)
    {
        $joins = RequestSudent::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_request.request_student')
            ->where('tbl_request.request_title', 'LIKE', '%' . $query . '%')
            ->where('tbl_student.student_id', $student_id)
            ->orderby('tbl_request.request_id', 'DESC')
            ->paginate($currentEntries);
        return RequestResource::collection($joins);
    }
}
