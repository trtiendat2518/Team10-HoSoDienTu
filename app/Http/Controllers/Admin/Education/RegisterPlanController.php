<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\RegisterPlan;
use App\Models\RegisterSubject;
use Illuminate\Http\Request;
use App\Http\Resources\RegisterPlanResource;

class RegisterPlanController extends Controller
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
     * @param  \App\Models\RegisterPlan  $registerPlan
     * @return \Illuminate\Http\Response
     */
    public function show($registerPlan)
    {
        $joins = RegisterPlan::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->join('tbl_program_detail', 'tbl_program_detail.program_detail_id', '=', 'tbl_register_plan.register_plan_program')
            ->join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
            ->join('tbl_program_type', 'tbl_program_type.program_type_id', '=', 'tbl_education_program.education_program_type')
            ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->whereNotIn('tbl_register_plan.register_plan_program', RegisterSubject::where('tbl_register_subject.register_subject_program', '!=', ['tbl_register_plan.register_plan_program'])->pluck('tbl_register_subject.register_subject_program'))
            ->where('tbl_register_plan.register_plan_student', $registerPlan)->get();

        return RegisterPlanResource::collection($joins);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RegisterPlan  $registerPlan
     * @return \Illuminate\Http\Response
     */
    public function edit(RegisterPlan $registerPlan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RegisterPlan  $registerPlan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegisterPlan $registerPlan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RegisterPlan  $registerPlan
     * @return \Illuminate\Http\Response
     */
    public function destroy(RegisterPlan $registerPlan)
    {
        //
    }
}
