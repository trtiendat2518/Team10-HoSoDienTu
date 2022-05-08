<?php

namespace Tests\Unit\Controllers\Admin\Posts;

use App\Models\Procedure;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class ProcedureTest extends TestCase
{
    /** @test */
    public function storeProcedureSuccess()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel = Procedure::orderBy('procedure_id', 'DESC')->first();
            $findToDel->delete();
        }
    }


    /** @test */
    public function storeProcedureCodeEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => ' ',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureTitleEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => ' ',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureContentEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => ' ',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureTimeEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => ' ',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureMethodEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => ' ',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureFeeEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => ' ',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureCategoryEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => ' ',
            'procedure_fee' => '40000',
            'procedure_category' => ' ',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureStatusEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => ' ',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => ' ',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function storeProcedureInputEmptyError()
    {
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => ' ',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => ' ',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(422);
    }


    /** @test */
    public function updateProcedureSuccess()
    {
        $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT1001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $findToDel = Procedure::orderBy('procedure_id', 'DESC')->first();

        $response = $this->json('PUT', 'api/admin/procedure/thu-tuc/' . $findToDel->procedure_id, [
            'procedure_code' => 'CTTT1002',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 1',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);

        $check = $response->assertStatus(200);
        if ($check == true) {
            $findToDel->delete();
        }
    }


    /** @test */
    public function destroyProcedureSuccess()
    {
        $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT2001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 2',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);


        $findToDel = Procedure::orderBy('procedure_id', 'DESC')->first();

        $response = $this->json('DELETE', 'api/admin/procedure/thu-tuc/' . $findToDel->procedure_id);

        $check = $response->assertStatus(200);
    }


    /** @test */
    public function changeProcedureSuccess()
    {
        $this->json('POST', 'api/admin/procedure/thu-tuc', [
            'procedure_code' => 'CTTT2001',
            'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 2',
            'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
            'procedure_time' => '3',
            'procedure_method' => '1',
            'procedure_fee' => '40000',
            'procedure_category' => '1',
            'procedure_status' => '0',
            'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

            'procedure_area' => '',
            'procedure_select' => '',
            'procedure_file' => '',
        ]);


        $findToDel = Procedure::orderBy('procedure_id', 'DESC')->first();

        $response = $this->json('PATCH', 'api/admin/procedure/thu-tuc/change/' . $findToDel->procedure_id);

        $check = $response->assertStatus(200);

        if ($check == true) {
            $findToDel->delete();
        }
    }


    /** @test */
    public function destroyAllProcedureSuccess()
    {
        for ($i = 1; $i < 3; $i++) {
            $this->json('POST', 'api/admin/procedure/thu-tuc', [
                'procedure_code' => 'CTTT200' . $i,
                'procedure_title' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự 2' . $i,
                'procedure_content' => 'Cấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sựCấp giấy chứng nhận tạm hoãn thi hành nghĩa vụ quân sự',
                'procedure_time' => '3',
                'procedure_method' => '1',
                'procedure_fee' => '40000',
                'procedure_category' => '1',
                'procedure_status' => '0',
                'procedure_input' => 'Họ và tên; Mã số sinh viên; Giới tính; Ngày sinh; Nơi sinh; Lớp; Khóa; Hộ khẩu thường trú; Số điện thoại; Email; Cơ sở sinh hoạt Đoàn mới',

                'procedure_area' => '',
                'procedure_select' => '',
                'procedure_file' => '',
            ]);
        }

        $procedure = array();
        $findToDel = Procedure::orderBy('procedure_id', 'DESC')->limit(2)->get();
        foreach ($findToDel as $key => $value) {
            array_push($procedure, $value->procedure_id);
        }
        $response = $this->json('POST', 'api/admin/procedure/thu-tuc/destroyall', [
            'procedure_id' => $procedure,
        ]);
        $response->assertStatus(200);
    }
}
