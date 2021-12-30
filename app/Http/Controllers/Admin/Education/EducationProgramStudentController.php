<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationProgram;
use App\Http\Resources\EducationProgramResource;

class EducationProgramStudentController extends Controller
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
    public function show($form_teacher_id)
    {
        $joins = EducationProgram::join('tbl_program_type', 'tbl_program_type.program_type_id', '=', 'tbl_education_program.education_program_type')
            ->join('tbl_program_detail', 'tbl_program_detail.program_detail_code', '=', 'tbl_education_program.education_program_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_class', 'tbl_class.class_course', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_form_teacher', 'tbl_form_teacher.form_teacher_class', '=', 'tbl_class.class_id')
            ->join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_form_teacher.form_teacher_lecturer')
            ->where('tbl_lecturer.lecturer_id', $form_teacher_id)
            ->orderBy('tbl_program_detail.program_detail_semester', 'ASC')
            ->get();
        return EducationProgramResource::collection($joins);
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
}
