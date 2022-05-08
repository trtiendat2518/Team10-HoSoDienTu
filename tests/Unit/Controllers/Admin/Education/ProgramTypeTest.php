<?php

namespace Tests\Unit\Controllers\Admin\Education;

use App\Models\ProgramType;
use Tests\TestCase;

class ProgramTypeTest extends TestCase
{
    /** @test */
    public function storeProgramTypeSuccess()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTESTTT',
            'program_type_name' => 'Test kiểm thử lần n',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();
            $findToDel->delete();
        }
    }

    /** @test */
    public function storeEmptyProgramTypeCodeError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => '',
            'program_type_name' => 'Test kiểm thử lần 1',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeProgramTypeCodeMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTESTKCHAY',
            'program_type_name' => 'Test kiểm thử lần 1',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeProgramTypeCodeMinLengthError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'D',
            'program_type_name' => 'Test kiểm thử lần 1',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
     public function storeProgramTypeCodeUniqueError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'program_type_code' => 'CTSH',
            'program_type_name' => 'Chương trình Đào Tạo',
            'program_type_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyProgramTypeNameError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => '',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeProgramTypeNameMaxLengthError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test kiểm thử lần 1 Test kiểm thử lần 1 Test kiểm thử lần 1Test kiểm thử lần 1 Test kiểm thử lần 1 Test kiểm thử lần 1 Test kiểm thử lần 1 Test kiểm thử lần 1Test kiểm thử lần 1 Test kiểm thử lần 1',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeProgramTypeNameMinLengthError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test',
            'program_type_status' => '1',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
     public function storeProgramTypeNameUniqueError()
    {
        $response = $this->json('POST', 'api/admin/class-sv/lop/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Chương trình sau Đại học',
            'program_type_status' => '0',
        ]);
        $check = $response->assertStatus(422);
    }

    /** @test */
    public function storeEmptyProgramTypeStatusError()
    {
        $response = $this->json('POST', 'api/admin/type/he-dao-tao', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '',
        ]);
        $check = $response->assertStatus(422);
    }

     /** @test */
    public function updateProgramTypeSucess()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'TEST',
            'program_type_name' => 'Test thử lần 2',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyProgramTypeCoderror()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => '',
            'program_type_name' => 'Test thử lần 2',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateProgramTypeCodeMaxLengthError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'CHAYTESTTTTTTTTTT',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateProgramTypeCodeMinLengthError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'C',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateEmptyProgramTypeNameError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => '',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateProgramTypeNameMaxLengthError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1 Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateProgramTypeNameMinLengthError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test 2',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function updateProgramTypeNameUniqueLengthError()
    {
        $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 1',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id, [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test kiem thu',
            'program_type_status' => '1',
        ]);

        $check = $response->assertStatus(422);
        if ($check == true) {
            $findToDel->delete();
        }
    }

    /** @test */
    public function deleteProgramTypeSuccess()
    {
         $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 2',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();
        $response = $this->json('DELETE', 'api/admin/type/he-dao-tao/' . $findToDel->program_type_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function changeProgramTypeSuccess()
    {
         $this->json('POST', 'api/admin/type/he-dao-tao/change', [
            'program_type_code' => 'CHAYTEST',
            'program_type_name' => 'Test thử lần 2',
            'program_type_status' => '1',
        ]);

        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->first();
        $response = $this->json('PATCH', 'api/admin/type/he-dao-tao/change/' . $findToDel->program_type_id);
        $response->assertStatus(200);
    }

    /** @test */
    public function destroyProgramTypeSuccess()
    {
        for($i = 1; $i < 3; $i++){
            $this->json('POST', 'api/admin/type/he-dao-tao/', [
            'program_type_code' => 'CHAYTEST' . $i,
            'program_type_name' => 'Test thử lần 2' . $i,
            'program_type_status' => '1',
        ]);

    }
        $programType = array();
        $findToDel = ProgramType::orderBy('program_type_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($programType, $value->program_type_id);
        }
        $response = $this->json('POST', 'api/admin/type/he-dao-tao/destroyall/', [
            'programtype' => $programType,
        ]);
        $response->assertStatus(200);
    }
}


