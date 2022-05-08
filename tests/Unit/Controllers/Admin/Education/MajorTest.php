<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\Major;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class MajorTest extends TestCase
{
    /** @test */
    public function storeMajor()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTTL',
            'major_name' => 'Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Major::orderBy('major_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    //Major Code Fail
    /** @test */
    public function storeMajorCodeMax()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTTLTLTLGLATDFGH',
            'major_name' => 'Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorCodeMin()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'T',
            'major_name' => 'Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorCodeSpace()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => ' ',
            'major_name' => 'Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorCodeSpecial()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => '@!#',
            'major_name' => 'Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    //Major Name Fail
    /** @test */
    public function storeMajorNameMax()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTL',
            'major_name' => 'Thuyết Trình Tự Lập Thuyết Trình Tự Lập Thuyết Trình Tự Lập Thuyết Trình Tự Lập Thuyết Trình Tự Lập Thuyết Trình Tự Lập',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorNameMin()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTL',
            'major_name' => 'Thuy',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorNameSpace()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTL',
            'major_name' => ' ',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeMajorNameSpecial()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTL',
            'major_name' => '#@!$@#$',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    //Major Faculty Error
    /** @test */
    public function storeMajorFacultyError()
    {
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTL',
            'major_name' => '#@!$@#$',
            'major_faculty' => '',
            'major_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }
    //Update
    /** @test */
    public function updateMajorSucess()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTT',
            'major_name' => 'Tự Thuyết Trình',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $findToDel = Major::orderBy('major_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id, [
            'major_code' => 'TTT',
            'major_name' => 'Tu Thuyet Trinh',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }
    //Update Fail
    /** @test */
    public function updateMajorNameMax()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTT',
            'major_name' => 'Tự Thuyết Trình',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $findToDel = Major::orderBy('major_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id, [
            'major_code' => 'TTT',
            'major_name' => 'Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh Tu Thuyet Trinh ',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }
    /** @test */
    public function updateMajorNameMin()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTT',
            'major_name' => 'Tự Thuyết Trình',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $findToDel = Major::orderBy('major_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id, [
            'major_code' => 'TTT',
            'major_name' => 'T',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }
    /** @test */
    public function updateMajorNameSpace()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTT',
            'major_name' => 'Tự Thuyết Trình',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $findToDel = Major::orderBy('major_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id, [
            'major_code' => 'TTT',
            'major_name' => ' ',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }
    /** @test */
    public function updateMajorNameSpecial()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TTT',
            'major_name' => 'Tự Thuyết Trình',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);
        $findToDel = Major::orderBy('major_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id, [
            'major_code' => 'TTT',
            'major_name' => '@!#$',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $check = $response->assertStatus(422);

        if ($check == true) {
            $findToDel->delete();
        }
    }
    //Detroy
    /** @test */
    public function deleteMajorSuccess()
    {
        $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
            'major_code' => 'TML',
            'major_name' => 'Thang May Man',
            'major_faculty' => '2',
            'major_status' => '1',
        ]);

        $findToDel = Major::orderBy('major_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/edu-major/chuyen-nganh/' . $findToDel->major_id);
        $response->assertStatus(200);
    }
    //Detroy All
    /** @test */
    public function destroyMajorSuccess()
    {
        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/edu-major/chuyen-nganh/', [
                'major_code' => 'TTT' . $i,
                'major_name' => 'Tự Thuyết Trình' . $i,
                'major_faculty' => '2',
                'major_status' => '1',
            ]);
        }

        $major = array();
        $findToDel = Major::orderBy('major_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($major, $value->major_id);
        }
        $response = $this->json('POST', 'api/admin/edu-major/chuyen-nganh/destroyall/', [
            'major' => $major,
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function importMajorSuccess()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major.xlsx'),
            'list_of_major.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Major::orderBy('major_id', 'DESC')->first();
            $findToDel->delete();
        }
    }
    /** @test */
    public function importMajorError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_error.xlsx'),
            'list_of_major_error.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailCodeMax()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_code_max.xlsx'),
            'list_of_major_fail_code_max.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailCodeMin()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_code_min.xlsx'),
            'list_of_major_fail_code_min.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailCodeError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_code_error.xlsx'),
            'list_of_major_fail_code_error.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailCodeSpecial()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_code_special.xlsx'),
            'list_of_major_fail_code_special.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailCodeSpace()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_code_space.xlsx'),
            'list_of_major_fail_code_space.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailNameMax()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_name_max.xlsx'),
            'list_of_major_fail_name_max.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailNameMin()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_name_min.xlsx'),
            'list_of_major_fail_name_min.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailNameSpecial()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_name_special.xlsx'),
            'list_of_major_fail_name_special.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailNameSpace()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_name_space.xlsx'),
            'list_of_major_fail_name_space.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailNameError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_name_error.xlsx'),
            'list_of_major_fail_name_error.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }

    /** @test */
    public function importMajorFailFaculty()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major_fail_faculty.xlsx'),
            'list_of_major_fail_faculty.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailFile()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major.rar'),
            'list_of_major.rar',
            null,
            null,
            true
        );
        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importMajorFailMimes()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_major.docx'),
            'list_of_major.docx',
            null,
            null,
            true
        );
        $response = $this->post('api/admin/edu-major/chuyen-nganh/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
}
