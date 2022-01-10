<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\RegisterSubject;
use Illuminate\Http\Request;
use App\Http\Resources\RegisterSubjectResource;

class RegisterSubjectController extends Controller
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
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function show(RegisterSubject $registerSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(RegisterSubject $registerSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegisterSubject $registerSubject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegisterSubject  $registerSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegisterSubject $registerSubject)
    {
        //
    }

    public function score($student_id)
    {
        $joins = RegisterSubject::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->join('tbl_program_detail', 'tbl_program_detail.program_detail_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->get();

        return RegisterSubjectResource::collection($joins);
    }
}
