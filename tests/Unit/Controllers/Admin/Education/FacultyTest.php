<?php

namespace Tests\Unit\Controllers\Admin\Education;


use App\Models\Faculty;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;

class FacultyTest extends TestCase
{
    //Create Faculty
    /** @test */
     public function storeFaculty()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'CBA',
            'faculty_name' => 'Cong Nghe Thap',
            'faculty_status' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();
            $findToDel->delete();
        }
    }
    //FacultyCode Fail
    /** @test */
    public function storeFacultyCodeMax()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PPVT',
            'faculty_name' => 'Phan Phung Vo Tin',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
      /** @test */
    public function storeFacultyCodeMin()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'P',
            'faculty_name' => 'Công nghệ Máy Tính',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
      /** @test */
    public function storeFacultyCodeErrorSpace()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => ' ',
            'faculty_name' => 'Công nghệ',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
     /** @test */
    public function storeFacultyCodeErrorSpecial()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => '@!#',
            'faculty_name' => 'Công nghệ',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    //FacultyName Fail
    /** @test */
    public function storeFacultyNameMax()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'ABC',
            'faculty_name' => 'Công nghệ máy tính toán đạo hàm thêm chức năng chuyên sâu và cuộc sống muôn màu khi bạn nhận ra code quá tuyệt vời',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeFacultyNameMin()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'ABC',
            'faculty_name' => 'a',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
    /** @test */
    public function storeFacultyNameErrorSpace()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'ABC',
            'faculty_name' => ' ',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }
    public function storeFacultyNameErrorSpecial()
    {
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'ABC',
            'faculty_name' => '@!#',
            'faculty_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    //Update
    /** @test */
    public function updateFacultySucess()
    {
        $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Cộng nghệ cao',
            'faculty_status' => '0',
        ]);
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-faculty/khoa/'.$findToDel->faculty_id, [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Phòng Văn Thư',
            'faculty_status' => '0',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }
    //Update Fail
    /** @test */
    public function updateFacultyNameMax()
    {
        $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Cộng nghệ Cao',
            'faculty_status' => '0',
        ]);
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-faculty/khoa/'.$findToDel->faculty_id, [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Công Nghệ Cao Công Nghệ Cao Công Nghệ Cao Công Nghệ Cao Công Nghệ Cao',
            'faculty_status' => '0',
        ]);

        $check = $response->assertStatus(422);
    }
     /** @test */
    public function updateFacultyNameMin()
    {
        $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Cộng nghệ Cao',
            'faculty_status' => '0',
        ]);
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-faculty/khoa/'.$findToDel->faculty_id, [
            'faculty_code' => 'PVT',
            'faculty_name' => 'C',
            'faculty_status' => '0',
        ]);

        $check = $response->assertStatus(422);
    }
     /** @test */
    public function updateFacultyNameErrorSpace()
    {
        $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Cộng nghệ Cao',
            'faculty_status' => '0',
        ]);
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-faculty/khoa/'.$findToDel->faculty_id, [
            'faculty_code' => 'PVT',
            'faculty_name' => ' ',
            'faculty_status' => '0',
        ]);

        $check = $response->assertStatus(422);
    }
     /** @test */
    public function updateFacultyNameErrorSpecial()
    {
        $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Cộng nghệ Cao',
            'faculty_status' => '0',
        ]);
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/edu-faculty/khoa/'.$findToDel->faculty_id, [
            'faculty_code' => 'PVT',
            'faculty_name' => '@!$',
            'faculty_status' => '0',
        ]);

        $check = $response->assertStatus(422);
    }
    /** @test */
    public function changeFaculty()
    {
         $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Phong Van Vo',
            'faculty_status' => '0',
        ]);

        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();
        $response = $this->json('PATCH', 'api/admin/edu-faculty/khoa/change/' . $findToDel->faculty_id);
        $response->assertStatus(200);
    }
    //Detroy
    /** @test */
    public function deleteFacultySuccess()
    {
         $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVT',
            'faculty_name' => 'Phong Van Thu',
            'faculty_status' => '0',
        ]);

        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/edu-faculty/khoa/' . $findToDel->faculty_id);
        $response->assertStatus(200);
    }
    //Detroy All
    /** @test */
    public function destroyMajorSuccess()
    {
        for($i = 1; $i < 3; $i++){
            $this->json('POST', 'api/admin/edu-faculty/khoa/', [
            'faculty_code' => 'PVA' .$i,
            'faculty_name' => 'Phong Van Hoa' .$i,
            'faculty_status' => '0',
        ]);
    }
        $faculty = array();
        $findToDel = Faculty::orderBy('faculty_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($faculty, $value->faculty_id);
        }
        $response = $this->json('POST', 'api/admin/edu-faculty/khoa/destroyall/', [
            'faculty' => $faculty,
        ]);
        $response->assertStatus(200);
    }
    //Import
    /** @test */
    public function importFacultySuccess()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty.xlsx'),
            'list_of_faculty.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Faculty::orderBy('faculty_id', 'DESC')->first();
            $findToDel->delete();
        }
    }
    /** @test */
    public function importFacultyFailNameMax()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_name_max.xlsx'),
            'list_of_faculty_fail_name_max.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailNameMin()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_name_min.xlsx'),
            'list_of_faculty_fail_name_min.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailNameError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_name_error.xlsx'),
            'list_of_faculty_fail_name_error.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailNameSpace()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_name_space.xlsx'),
            'list_of_faculty_fail_name_space.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailNameSpecial()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_name_special.xlsx'),
            'list_of_faculty_fail_name_special.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );
        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailCodeMin()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_code_min.xlsx'),
            'list_of_faculty_fail_code_min.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailCodeMax()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_code_max.xlsx'),
            'list_of_faculty_fail_code_max.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailCodeError()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_code_error.xlsx'),
            'list_of_faculty_fail_code_error.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailCodeSpace()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_code_space.xlsx'),
            'list_of_faculty_fail_code_space.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailCodeSpecial()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty_fail_code_special.xlsx'),
            'list_of_faculty_fail_code_special.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    /** @test */
    public function importFacultyFailFile()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty.rar'),
            'list_of_faculty.rar',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
    
    /** @test */
    public function importFacultyFailMimes()
    {
        $file = new UploadedFile(
            base_path('public/tests/list_of_faculty.docx'),
            'list_of_faculty.docx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->post('api/admin/edu-faculty/khoa/import', [
            'fileImport' => $file
        ]);
        $check = $response->assertStatus(302);
    }
}
