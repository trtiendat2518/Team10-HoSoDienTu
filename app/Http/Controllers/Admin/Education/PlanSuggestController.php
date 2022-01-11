<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\PlanSuggest;
use Illuminate\Http\Request;
use App\Http\Resources\PlanSuggestResource;

class PlanSuggestController extends Controller
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
     * @param  \App\Models\PlanSuggest  $planSuggest
     * @return \Illuminate\Http\Response
     */
    public function show(PlanSuggest $planSuggest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PlanSuggest  $planSuggest
     * @return \Illuminate\Http\Response
     */
    public function edit(PlanSuggest $planSuggest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PlanSuggest  $planSuggest
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, PlanSuggest $planSuggest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanSuggest  $planSuggest
     * @return \Illuminate\Http\Response
     */
    public function destroy(PlanSuggest $planSuggest)
    {
        //
    }

    public function showdata($lectuer_id, $currentEntries)
    {
        $joins = PlanSuggest::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_plan_suggest.plan_suggest_lecturer')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_lecturer.lecturer_id', $lectuer_id)
            ->paginate($currentEntries);

        return PlanSuggestResource::collection($joins);
    }

    public function search($lectuer_id, $query, $currentEntries)
    {
        $joins = PlanSuggest::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_plan_suggest.plan_suggest_lecturer')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_class.class_name', 'LIKE', '%' . $query . '%')
            ->where('tbl_lecturer.lecturer_id', $lectuer_id)
            ->orwhere('tbl_course.course_code', 'LIKE', '%' . $query . '%')
            ->where('tbl_lecturer.lecturer_id', $lectuer_id)
            ->paginate($currentEntries);

        return PlanSuggestResource::collection($joins);
    }

    public function change($plan_suggest_id)
    {
        $suggs = PlanSuggest::find($plan_suggest_id);
        if ($suggs->plan_suggest_status == 0) {
            $suggs->plan_suggest_status = 1;
            $suggs->save();
        } else {
            $suggs->plan_suggest_status = 0;
            $suggs->save();
        }
    }
}
