<?php

namespace Tests\Unit\Controllers\Admin\Education;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use app\Models\EducationProgram;
use App\Models\ProgramDetail;

class EducationProgramTest extends TestCase
{
    /** @test */
    public function storeEducationProgramSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
            $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeEducationProgramCodeEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => '',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramCodeMaxLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTESTTTTTTTTTTTTTTTTTTTTTTTTTTTT',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramCodeUniqueError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'CTDTK24',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramCodeSpecialCharacterError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'TEST!@#$',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramTypeEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramSCourseEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramYearEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramYearMaxLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '44444444444444444444444444',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramStatusEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramFileEmptyError()
    {
        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  '',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramFileExcelError()
    {
        $file = new UploadedFile(
            base_path('public/tests/img/img-unittest.png'),
            'img-unittest.png',
            null,
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEducationProgramFileError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.rar'),
            'education_program.rar',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function updateEducationProgramSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
        $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();

        $response = $this->json('PUT', 'api/admin/program/chuong-trinh-dao-tao/' . $findToDel->education_program_id, [
            'education_program_type' => '10',
            'education_program_year' => '5',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEducationProgramTypeEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
        $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();

        $response = $this->json('PUT', 'api/admin/program/chuong-trinh-dao-tao/' . $findToDel->education_program_id, [
            'education_program_type' => '',
            'education_program_year' => '5',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEducationProgramYearEmptyError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
        $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();

        $response = $this->json('PUT', 'api/admin/program/chuong-trinh-dao-tao/' . $findToDel->education_program_id, [
            'education_program_type' => '10',
            'education_program_year' => '',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEducationProgramYearMaxLengthError()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
        $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();

        $response = $this->json('PUT', 'api/admin/program/chuong-trinh-dao-tao/' . $findToDel->education_program_id, [
            'education_program_type' => '10',
            'education_program_year' => '55555555555555555555555555555',
        ]);
        $check = $response->assertStatus(422);
        if ($check == true) {
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteEducationProgramSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/program/chuong-trinh-dao-tao/' . $findToDel->education_program_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function deleteAllEducationProgramSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
                'education_program_code' => 'TEST' . $i,
                'education_program_type' => '1',
                'education_program_course' => '2',
                'education_program_year' => '4',
                'education_program_faculty' => '2',
                'education_program_status' => '0',
                'file_data' =>  $file,
            ]);
        }

        $educationProgram = array();
        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($educationProgram, $value->education_program_id);
        }
        $response = $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao/destroyall/', [
            'educationProgram' => $educationProgram,
        ]);
        $response->assertStatus(200);
    }

    /** @test */
    public function changeEducationProgramStatusSucess()
    {
        $file = new UploadedFile(
            base_path('public/tests/education_program.xlsx'),
            'education_program.xlsx',
            'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            null,
            true
        );

        $this->json('POST', 'api/admin/program/chuong-trinh-dao-tao', [
            'education_program_code' => 'UNITTEST',
            'education_program_type' => '1',
            'education_program_course' => '2',
            'education_program_year' => '4',
            'education_program_faculty' => '2',
            'education_program_status' => '0',
            'file_data' =>  $file,
        ]);

        $findToDel = EducationProgram::orderBy('education_program_id', 'DESC')->first();

        $response = $this->json('PATCH', 'api/admin/program/chuong-trinh-dao-tao/change/' . $findToDel->education_program_id);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findtoDelDetail = ProgramDetail::where('program_detail_code', $findToDel->education_program_code)->get();
            foreach ($findtoDelDetail as $key => $value) {
                $value->delete();
            }
            $findToDel->delete();
        }
    }
}
