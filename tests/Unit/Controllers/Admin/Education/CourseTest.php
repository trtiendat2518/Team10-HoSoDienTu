<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\Course;
use Tests\TestCase;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\UploadedFile;

class CourseTest extends TestCase
{
    /** @test */
    public function storeCourseSuccess()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K31',
            'course_name' => 'Khoá 31',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Course::orderBy('course_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeEmptyCourseCodeError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => ' ',
            'course_name' => 'Khoá 30',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseCodeMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K301',
            'course_name' => 'Khoá 32',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseCodeMinLengthError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K',
            'course_name' => 'Khoá 32',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseCodeUniqueError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K25',
            'course_name' => 'Khoá 25',
            'course_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseCodeSpecialCharacterError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => '@#$@#$@',
            'course_name' => 'Khoá 25',
            'course_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyCourseNameError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K30',
            'course_name' => '',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseNameMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K30',
            'course_name' => 'Khoá 3000000000000000000000000000000000000000000000000000000000',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseNameMinLengthError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K33',
            'course_name' => 'Kho',
            'course_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseNameUniqueError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K25',
            'course_name' => 'Khoá 25',
            'course_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeCourseNameSpecialCharacterError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K25',
            'course_name' => '@#$@#$@',
            'course_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyCourseStatusError()
    {
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
            'course_code' => 'K30',
            'course_name' => 'Khoá 30',
            'course_status' => '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateCourseSucess()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K35',
            'course_name' => 'Khoá 35',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K31',
            'course_name' => 'Khoá 31',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }


    /** @test */
    public function updateEmptyCourseNameError()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K34',
            'course_name' => '',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCourseNameMaxLengthError()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K30',
            'course_name' => 'Khoá 30000000000000000000000000000000000000000000000000000',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCourseNameMinLengthError()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K30',
            'course_name' => 'Kho',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCourseNameCharacterError()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K30',
            'course_name' => '@#$@#$@#',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateCourseNameUniqueError()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id, [
            'course_code' => 'K36',
            'course_name' => 'Khoá 24',
            'course_status' => '0',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteCourseSuccess()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/edu-course/khoa-hoc/' . $findToDel->course_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function importCourseSuccess()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course.xlsx'),
            'list_of_course.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Course::orderBy('course_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function importCourseCodeEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_empty.xlsx'),
            'list_of_course_empty.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseCodeNotSpecialError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_notspecial.xlsx'),
            'list_of_course_notspecial.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseCodeUniqueError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_unique.xlsx'),
            'list_of_course_unique.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseCodeMaxLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_max_length.xlsx'),
            'list_of_course_max_length.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseCodeMinLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_min_length.xlsx'),
            'list_of_course_min_length.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseNameEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_name_empty.xlsx'),
            'list_of_name_course_empty.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseNameNotSpecialError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_name_notspecial.xlsx'),
            'list_of_course_name_notspecial.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseNameUniqueError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_name_unique.xlsx'),
            'list_of_course_name_unique.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseNameMaxLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_name_max_length.xlsx'),
            'list_of_course_name_max_length.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importCourseNameMinLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_course_name_min_length.xlsx'),
            'list_of_course_name_min_length.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-course/khoa-hoc/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function destroyCourseSuccess()
    {
        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/edu-course/khoa-hoc', [
                'course_code' => '36' . $i,
                'course_name' => 'Khoá 36' . $i,
                'course_status' => '0',
            ]);
        }

        $course = array();
        $findToDel = Course::orderBy('course_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($course, $value->course_id);
        }
        $response = $this->json('POST', 'api/admin/edu-course/khoa-hoc/destroyall/', [
            'course' => $course,
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function changeCourseSuccess()
    {
        $this->json('POST', 'api/admin/edu-course/khoa-hoc/', [
            'course_code' => 'K36',
            'course_name' => 'Khoá 36',
            'course_status' => '0',
        ]);

        $findToDel = Course::orderBy('course_id', 'DESC')->first();
        $response = $this->json('PATCH', 'api/admin/edu-course/khoa-hoc/change/' . $findToDel->course_id);
        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }
}
