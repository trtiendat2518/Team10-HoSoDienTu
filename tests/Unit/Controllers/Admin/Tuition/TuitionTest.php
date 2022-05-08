<?php

namespace Tests\Unit\Controllers\Admin\Tuition;

use App\Models\Tuition;
use Tests\TestCase;


class TuitionTest extends TestCase
{
    /** @test */
    public function storeTuitionSuccess()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeEmptyTuitionCodeError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyTuitionFacultyError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyTuitionMajorError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyTuitionFeeError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeTuitionFeeMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '111111111111',
            'tuition_discount' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyTuitionDiscountError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeTuitionDiscountIntegerError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => 'h',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeTuitionDiscountSuccess()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);
        $check = $response->assertStatus(200);
    }

    /** @test */
    public function storeTuitionDiscountUnderZeroError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0.5',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeTuitionDiscountThanOneHundredError()
    {
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '101',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateTuitionSucess()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '1000000',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyTuitionCourseError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '1000000',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyTuitionFacultyError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '',
            'tuition_major' => '1',
            'tuition_fee' => '1000000',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyTuitionMajorError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '',
            'tuition_fee' => '1000000',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyTuitionFeeError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateTuitionFeeMaxLengthError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '2000000000000',
            'tuition_discount' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyTuitionDiscountError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '2000000',
            'tuition_discount' => '',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateTuitionDiscountIntegerError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '2000000',
            'tuition_discount' => 'h',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateTuitionDiscountUnderZeroError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '2000000',
            'tuition_discount' => '0.5',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateTuitionDiscountThanOneHundredError()
    {
        $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '5',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id, [
            'tuition_course' => '2',
            'tuition_faculty' => '1',
            'tuition_major' => '1',
            'tuition_fee' => '2000000',
            'tuition_discount' => '101',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }


    /** @test */
    public function deleteTuitionSuccess()
    {
         $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/', [
            'tuition_course' => '1',
            'tuition_faculty' => '2',
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '100',
        ]);

        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/tuition-management/quan-ly-hoc-phi/' . $findToDel->tuition_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function destroyTuitionSuccess()
    {
        for($i = 1; $i < 3; $i++){
            $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi', [
            'tuition_course' => '1' . $i,
            'tuition_faculty' => '2'. $i,
            'tuition_major' => '2',
            'tuition_fee' => '2000000',
            'tuition_discount' => '100',
        ]);

    }

        $tuition = array();
        $findToDel = Tuition::orderBy('tuition_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($tuition, $value->tuition_id);
        }
        $response = $this->json('POST', 'api/admin/tuition-management/quan-ly-hoc-phi/destroyall/', [
            'tuition' => $tuition,
        ]);
        $response->assertStatus(200);
    }
}
