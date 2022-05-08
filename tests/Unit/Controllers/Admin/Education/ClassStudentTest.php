<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\ClassStudent;
use Tests\TestCase;

class ClassStudentTest extends TestCase
{
    /** @test */
    public function storeClassStudentSuccess()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM35',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeClassStudentNameMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM1000000000000000000000000000000000000000000000000',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeClassStudentEmptyNameError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => ' ',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
     public function storeClassStudentCharacterNameError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => '!$!&$',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
     public function storeClassStudentUniqueNameError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'IT05',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeClassStudentEmptyCourseError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM22',
            'class_course' => '',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeClassStudentEmptyMajorError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM22',
            'class_course' => '2',
            'class_major' => '',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateClassStudentSucess()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM36',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => 'PM20',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassStudentEmptyNameError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM20',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => '',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassMaxLengthError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM1001',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => 'PM1000000000000000000000000000000000000000000000002',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassEmptyNameError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PMTest1',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => ' ',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassCharacterNameError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => '*@%&%%()',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassEmptyCourseError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => 'PMTest2',
            'class_course' => '',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassEmptyMajorError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateClassEmptyFormTeacherError()
    {
        $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/class-sv/lop/' . $findToDel->class_id, [
            'class_name' => 'PMTest2',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '',
            'class_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteClassStudentSuccess()
    {
         $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM223',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/class-sv/lop/' . $findToDel->class_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function changeClassStudentSuccess()
    {
         $this->json('POST', 'api/admin/class-sv/lop/', [
            'class_name' => 'PM223',
            'class_course' => '2',
            'class_major' => '2',
            'class_faculty' => '2',
            'class_form_teacher' => '4',
            'class_status' => '0',
        ]);

        $findToDel = ClassStudent::orderBy('class_id', 'DESC')->first();
        $response = $this->json('PATCH', 'api/admin/class-sv/lop/change/' . $findToDel->class_id);
        $response->assertStatus(200);
    }
}
