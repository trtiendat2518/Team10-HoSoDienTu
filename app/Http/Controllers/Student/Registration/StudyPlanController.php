<?php

namespace App\Http\Controllers\Student\Registration;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EducationProgram;
use App\Models\RegisterSubject;
use App\Models\PlanSuggest;
use App\Http\Resources\EducationProgramResource;
use App\Http\Resources\PlanSuggestResource;

class StudyPlanController extends Controller
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
    public function show($student_id)
    {
        $joins = EducationProgram::join('tbl_program_type', 'tbl_program_type.program_type_id', '=', 'tbl_education_program.education_program_type')
            ->join('tbl_program_detail', 'tbl_program_detail.program_detail_code', '=', 'tbl_education_program.education_program_code')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_education_program.education_program_course')
            ->join('tbl_faculty', 'tbl_faculty.faculty_id', '=', 'tbl_education_program.education_program_faculty')
            ->join('tbl_student', 'tbl_student.student_course', '=', 'tbl_education_program.education_program_course')
            ->where('tbl_student.student_id', $student_id)
            ->orderBy('tbl_program_detail.program_detail_semester', 'ASC')
            ->get();
        return EducationProgramResource::collection($joins);
    }

    public function showdata($student_id)
    {
        $joins = RegisterSubject::join('tbl_program_detail', 'tbl_program_detail.program_detail_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->where('tbl_register_subject.register_subject_student', $student_id)
            ->get();
        return EducationProgramResource::collection($joins);
    }

    public function show_suggest_all($student_id)
    {
        $joins = PlanSuggest::join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->join('tbl_student', 'tbl_student.student_class', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->where('tbl_student.student_id', $student_id)
            ->where('tbl_plan_suggest.plan_suggest_student', 0)->get();
        return PlanSuggestResource::collection($joins);
    }

    public function show_suggest_only($student_id)
    {
        $joins = PlanSuggest::join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_plan_suggest.plan_suggest_student')
            ->where('tbl_student.student_id', $student_id)->get();
        return PlanSuggestResource::collection($joins);
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
