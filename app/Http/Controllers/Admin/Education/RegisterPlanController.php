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
    public function show($student_id)
    {
        $get = RegisterSubject::join('tbl_calendar_subject', 'tbl_calendar_subject.calendar_subject_id', '=', 'tbl_register_subject.register_subject_program')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
            ->where('tbl_register_subject.register_subject_student', $student_id)->get();

        $joins = RegisterPlan::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_student.student_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_register_plan.register_plan_student', $student_id);

        foreach ($get as $key => $value) {
            $value->subject_id;
            $joins->where('tbl_register_plan.register_plan_program', '!=', $value->subject_id);
        }
        $results = $joins->get();

        return RegisterPlanResource::collection($results);
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
