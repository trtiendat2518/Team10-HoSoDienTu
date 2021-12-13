<?php

namespace App\Http\Controllers\Admin\Users;

use App\Http\Controllers\Controller;
use App\Models\FormTeacher;
use App\Models\Lecturer;
use Illuminate\Http\Request;
use App\Http\Resources\FormTeacherResource;

class FormTeacherController extends Controller
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
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function show($currentEntries)
    {
        $joins = FormTeacher::join('tbl_lecturer', 'tbl_lecturer.lecturer_code', '=', 'tbl_form_teacher.form_teacher_code')->join('tbl_faculty', 'tbl_faculty.faculty_code', '=', 'tbl_lecturer.lecturer_faculty')->orderby('tbl_form_teacher.form_teacher_id','DESC')->paginate($currentEntries);
        return FormTeacherResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function edit(FormTeacher $formTeacher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FormTeacher $formTeacher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FormTeacher  $formTeacher
     * @return \Illuminate\Http\Response
     */
    public function destroy(FormTeacher $formTeacher)
    {
        //
    }

    // public function showdata($lecturer_id, $currentEntries)
    // {
    //     $lec = Lecturer::where('lecturer_code', $lecturer_id)->first();
    //     $joins = FormTeacher::join('tbl_lecturer', 'tbl_lecturer.lecturer_code', '=', 'tbl_lecturer.lecturer_code')->join('tbl_faculty', 'tbl_faculty.faculty_code', '=', 'tbl_lecturer.lecturer_faculty')->where('tbl_lecturer.lecturer_faculty', $lec->lecturer_faculty)->paginate($currentEntries);
    //     return FormTeacherResource::collection($joins);
    // }
}
