<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\PlanSuggest;
use App\Models\PlanSuggestDetail;
use Tests\TestCase;

class PlanSuggestTest extends TestCase
{
    /** @test */
    public function storePlanSuggestSucess()
    {
        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->first();
            $findtoDelDetail = PlanSuggestDetail::where('plansuggest_detail_ref', $findtoDel->plan_suggest_id)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findtoDel->delete();
        }
    }

    /** @test */
    public function storePlanSuggestClassEmptyError()
    {
        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storePlanSuggestStudentEmptyError()
    {
        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '',
            'subject' => ['5', '55', '56'],
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storePlanSuggestSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updatePlanSuggestSucess()
    {
        $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);

        $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->first();

        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/upgrade/' . $findtoDel->plan_suggest_id, [
            'subject' => ['5', '55', '56', '3'],
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDelDetail = PlanSuggestDetail::where('plansuggest_detail_ref', $findtoDel->plan_suggest_id)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findtoDel->delete();
        }
    }

    /** @test */
    public function updatePlanSuggestSubjectEmptyError()
    {
        $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);

        $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->first();

        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/upgrade/' . $findtoDel->plan_suggest_id, [
            'subject' => '',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            $findtoDelDetail = PlanSuggestDetail::where('plansuggest_detail_ref', $findtoDel->plan_suggest_id)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findtoDel->delete();
        }
    }

    /** @test */
    public function deletePlanSuggestSuccess()
    {
        $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);

        $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/' . $findtoDel->plan_suggest_id);
        $check = $response->assertStatus(200);
    }

    /** @test */
    public function changePlanSuggestStatusSuccess()
    {
        $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
            'plan_suggest_lecturer' => '51',
            'plan_suggest_class' => '1',
            'plan_suggest_student' => '11',
            'subject' => ['5', '55', '56'],
        ]);

        $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->first();

        $response = $this->json('PATCH', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/change/' . $findtoDel->plan_suggest_id);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDelDetail = PlanSuggestDetail::where('plansuggest_detail_ref', $findtoDel->plan_suggest_id)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findtoDel->delete();
        }
    }

    /** @test */
    public function deleteAllPlanSuggestSuccess()
    {
        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv', [
                'plan_suggest_lecturer' => '51',
                'plan_suggest_class' => '1',
                'plan_suggest_student' => '11',
                'subject' => ['5', '55', '56'],
            ]);
        }
        $plan_suggest_id = array();
        $findtoDel = PlanSuggest::orderBy('plan_suggest_id', 'DESC')->limit(2)->get();
        foreach ($findtoDel as $key => $value) {
            array_push($plan_suggest_id, $value->plan_suggest_id);
        }

        $response = $this->json('POST', 'api/admin/suggest-plan/goi-y-ke-hoach-hoc-tap-sv/destroyall', [
            'plan_suggest_id' => $plan_suggest_id
        ]);
        $check = $response->assertStatus(200);
    }
}
