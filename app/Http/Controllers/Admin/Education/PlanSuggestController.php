<?php

namespace App\Http\Controllers\Admin\Education;

use App\Http\Controllers\Controller;
use App\Models\PlanSuggest;
use App\Models\PlanSuggestDetail;
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
        $data = $request->validate([
            'plan_suggest_class' => ['required'],
            'plan_suggest_student' => ['required'],
            'subject' => ['required'],
        ], [
            'plan_suggest_class.required' => 'Vui lòng chọn lớp học!',
            'plan_suggest_student.required' => 'Vui lòng chọn sinh viên!',
            'subject.required' => 'Vui lòng chọn môn học!'
        ]);

        $plan_new = new PlanSuggest();
        $plan_new->plan_suggest_class = $data['plan_suggest_class'];
        $plan_new->plan_suggest_student = $data['plan_suggest_student'];
        $plan_new->plan_suggest_lecturer = $request->plan_suggest_lecturer;
        $plan_new->save();

        foreach ($request->subject as $subject_id) {
            $detail_new = new PlanSuggestDetail();
            $detail_new->plansuggest_detail_ref = $plan_new->plan_suggest_id;
            $detail_new->plansuggest_detail_program = $subject_id;
            $detail_new->save();
        }
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
    public function update(Request $request, $planSuggest)
    {
        // patch
    }

    public function upgrade(Request $request, $planSuggest)
    {
        $data = $request->validate([
            'subject' => ['required']
        ], [
            'subject.required' => 'Vui lòng chọn môn học!'
        ]);

        $plan_detail = PlanSuggestDetail::where('plansuggest_detail_ref', $planSuggest)->get();
        foreach ($plan_detail as $value) {
            $value->delete();
        }

        foreach ($request->subject as $subject_id) {
            $detail_new = new PlanSuggestDetail();
            $detail_new->plansuggest_detail_ref = $planSuggest;
            $detail_new->plansuggest_detail_program = $subject_id;
            $detail_new->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PlanSuggest  $planSuggest
     * @return \Illuminate\Http\Response
     */
    public function destroy($planSuggest)
    {
        $plan_suggest = PlanSuggest::find($planSuggest);
        $plan_detail = PlanSuggestDetail::where('plansuggest_detail_ref', $planSuggest)->get();
        foreach ($plan_detail as $value) {
            $value->delete();
        }
        $plan_suggest->delete();
    }

    public function showdata($lectuer_id, $currentEntries)
    {
        $joins = PlanSuggest::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_plan_suggest.plan_suggest_lecturer')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->where('tbl_lecturer.lecturer_id', $lectuer_id)
            ->orderby('tbl_plan_suggest.plan_suggest_id', 'DESC')
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

    public function onlyone($plan_suggest_id)
    {
        $joins = PlanSuggest::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_plan_suggest.plan_suggest_lecturer')
            ->join('tbl_class', 'tbl_class.class_id', '=', 'tbl_plan_suggest.plan_suggest_class')
            ->join('tbl_course', 'tbl_course.course_id', '=', 'tbl_class.class_course')
            ->join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->where('tbl_plan_suggest.plan_suggest_id', $plan_suggest_id)
            ->get();

        return PlanSuggestResource::collection($joins);
    }

    public function destroyall(Request $request, $plan_suggest_id = null)
    {
        if ($request->plan_suggest_id) {
            foreach ($request->plan_suggest_id as $id) {
                $plan_suggest = PlanSuggest::where('plan_suggest_id', $id)->get();
                foreach ($plan_suggest as $suggest) {
                    $plan_detail = PlanSuggestDetail::where('plansuggest_detail_ref', $suggest->plan_suggest_id)->get();
                    foreach ($plan_detail as $detail) {
                        $detail->delete();
                    }
                    $suggest->delete();
                }
            }
        }
    }

    public function detail($plan_suggest_id)
    {
        $joins = PlanSuggest::join('tbl_lecturer', 'tbl_lecturer.lecturer_id', '=', 'tbl_plan_suggest.plan_suggest_lecturer')
            ->join('tbl_plansuggest_detail', 'tbl_plansuggest_detail.plansuggest_detail_ref', '=', 'tbl_plan_suggest.plan_suggest_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_plansuggest_detail.plansuggest_detail_program')
            ->where('tbl_plan_suggest.plan_suggest_id', $plan_suggest_id)
            ->get();

        return PlanSuggestResource::collection($joins);
    }
}
