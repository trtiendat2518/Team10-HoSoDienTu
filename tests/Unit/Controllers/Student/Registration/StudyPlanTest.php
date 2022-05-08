<?php

namespace Tests\Unit\Controllers\Student\Registration;

use App\Models\RegisterPlan;
use Carbon\Carbon;
use Tests\TestCase;

class StudyPlanTest extends TestCase
{
    /** @test */
    public function registerStudyPlanSucess()
    {
        $response = $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap', [
            'student_id' => '11',
            'subject' => ['20', '19', '2', '1'],
            'semester' => '1',
            'yearstart' => '2022',
            'type' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = RegisterPlan::orderBy('register_plan_id', 'DESC')->limit(4)->get();
            foreach ($findToDel as $key => $value) {
                $value->delete();
            }
        }
    }

    /** @test */
    public function registerStudyPlanSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap', [
            'student_id' => '11',
            'subject' => '',
            'semester' => '1',
            'yearstart' => '2022',
            'type' => '1',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function registerStudyPlanSecondarySucess()
    {
        $response = $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap/register-again', [
            'student_id' => '11',
            'subject' => ['20', '19', '2', '1'],
            'semester' => '1',
            'year_start' => '2022',
            'type' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = RegisterPlan::orderBy('register_plan_id', 'DESC')->limit(4)->get();
            foreach ($findToDel as $key => $value) {
                $value->delete();
            }
        }
    }

    /** @test */
    public function registerStudyPlanSecondarySubjectEmptyError()
    {
        $response = $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap/register-again', [
            'student_id' => '11',
            'subject' => '',
            'semester' => '1',
            'year_start' => '2022',
            'type' => '1',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function cancelStudyPlanSecondarySucess()
    {
        $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap/register-again', [
            'student_id' => '11',
            'subject' => ['20'],
            'semester' => '1',
            'year_start' => '2022',
            'type' => '1',
        ]);

        $findToDel = RegisterPlan::orderBy('register_plan_id', 'DESC')->first();

        $response = $this->json('POST', 'api/student/study-plan/dang-ky-ke-hoach-hoc-tap/cancel-register-again/' . $findToDel->register_plan_id);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }
}
