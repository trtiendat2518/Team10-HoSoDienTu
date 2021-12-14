<?php

namespace App\Imports;

use App\Models\ProgramDetail;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProgramDetailUpdateImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(string $program_code)
    {
        $this->program_code = $program_code;
    }

    public function model(array $row)
    {
        $code = $this->program_code;

        return new ProgramDetail([
            'program_detail_code'=>$code,
            'program_detail_subject'=>$row['ma_mon_hoc'],
            'program_detail_semester'=>$row['hoc_ky'],
            'program_detail_note'=>$row['ghi_chu'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_mon_hoc' => 'required|notspecial_spaces', //|unique:tbl_program_detail,program_detail_subject
            'hoc_ky' => 'required|numeric|max:11',
            'ghi_chu' => 'max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_mon_hoc.required' => 'Mã Môn học tại hàng :row không được để trống',
            'ma_mon_hoc.notspecial_spaces' => 'Mã Môn học tại hàng :row không chứa ký tự đặc biệt',
            //'ma_mon_hoc.unique' => 'Mã Môn học tại hàng :row đã có trong chương trình đào tạo',

            'hoc_ky.required' => 'Số học kỳ tại hàng :row không được để trống',
            'hoc_ky.numeric' => 'Số học kỳ tại hàng :row phải là ký tự số',
            'hoc_ky.max' => 'Số học kỳ tại hàng :row tối đa 11 số',

            'ghi_chu.max' => 'Ghi chú tại hàng :row vượt quá 100 ký tự',
        ];
    }
}
