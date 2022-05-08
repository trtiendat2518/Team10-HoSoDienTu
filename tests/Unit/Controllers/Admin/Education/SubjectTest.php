<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\Subject;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class SubjectTest extends TestCase
{

    /** @test */
    public function storeSubjectSucess()
    {
        $response = $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDel = Subject::orderBy('subject_id', 'DESC')->first();
            $findtoDel->delete();
        }
    }

    /** @test */
    public function storeSubjectEmptyError()
    {
        $response = $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => '',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function storeSubjectLengthError()
    {
        $response = $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '433333333333333333333333333333333333333333333',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function storeSubjectSumScoreError()
    {
        $response = $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '433333333333333333333333333333333333333333333',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '90',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function updateSubjectSucess()
    {
        $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);

        $findtoDel = Subject::orderBy('subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/manage/mon-hoc/' . $findtoDel->subject_id, [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test 2',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDel->delete();
        }
    }

    /** @test */
    public function updateSubjectEmptyError()
    {
        $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);

        $findtoDel = Subject::orderBy('subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/manage/mon-hoc/' . $findtoDel->subject_id, [
            'subject_code' => 'DTH0320',
            'subject_name' => '',
            'subject_credit' => '3',
            'subject_faculty' => '2',
            'subject_practice_period' => '90',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '30',
            'subject_score_exam' => '60',
            'subject_score_final' => '10',
            'subject_type' => '0',
            'subject_status' => '0',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function updateSubjectLengthError()
    {
        $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);

        $findtoDel = Subject::orderBy('subject_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/manage/mon-hoc/' . $findtoDel->subject_id, [
            'subject_code' => 'DTH0320',
            'subject_name' => 'Chuyên đề Software Process&Quality Management',
            'subject_credit' => '66666666666666666666666666666666666666666',
            'subject_faculty' => '2',
            'subject_practice_period' => '90',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '30',
            'subject_score_exam' => '60',
            'subject_score_final' => '10',
            'subject_type' => '0',
            'subject_status' => '0',
        ]);
        $response->assertStatus(422);
    }

    /** @test */
    public function deleteSubjectSucess()
    {
        $this->json('POST', 'api/admin/manage/mon-hoc', [
            'subject_code' => 'DTH1234',
            'subject_name' => 'Mon hoc Unit Test',
            'subject_credit' => '4',
            'subject_faculty' => '2',
            'subject_practice_period' => '50',
            'subject_theory_period' => '30',
            'subject_score_exercise' => '20',
            'subject_score_exam' => '40',
            'subject_score_final' => '40',
            'subject_type' => '1',
            'subject_status' => '0',
        ]);

        $findtoDel = Subject::orderBy('subject_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/manage/mon-hoc/' . $findtoDel->subject_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function exportSubjectSucess()
    {
        $response = $this->json('GET', 'api/admin/manage/mon-hoc/export/2');
        $response->assertStatus(200);
    }

    /** @test */
    public function importSubjectSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_subject.xlsx'),
            'list_of_subject.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/manage/mon-hoc/import/2', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDel = Subject::orderBy('subject_id', 'DESC')->limit(2)->get();
            foreach ($findtoDel as $key => $value) {
                $value->delete();
            }
        }
    }

    /** @test */
    public function importSubjectExistError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_subject_exist.xlsx'),
            'list_of_subject_exist.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/manage/mon-hoc/import/2', [
            'fileImport' => $file
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function importSubjectEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_subject_empty.xlsx'),
            'list_of_subject_empty.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/manage/mon-hoc/import/2', [
            'fileImport' => $file
        ]);
        $response->assertStatus(302);
    }

    /** @test */
    public function importSubjectCharacterSpecialError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_subject_special.xlsx'),
            'list_of_subject_special.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/manage/mon-hoc/import/2', [
            'fileImport' => $file
        ]);
        $response->assertStatus(302);
    }
}
