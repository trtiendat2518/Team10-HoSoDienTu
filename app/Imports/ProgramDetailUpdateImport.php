<?php

namespace App\Imports;

use Illuminate\Validation\Rule;
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
        $row['ma_mon_hoc'] = $row['program_detail_subject'];

        return new ProgramDetail([
            'program_detail_code' => $code,
            'program_detail_subject' => $row['ma_mon_hoc'],
            'program_detail_semester' => $row['hoc_ky'],
            'program_detail_note' => $row['ghi_chu'],
        ]);
    }

    public function rules(): array
    {
        return [
            'program_detail_subject' => [
                'required', 'notspecial_spaces',
                Rule::unique('tbl_program_detail')->where(function ($query) {
                    $query->where('program_detail_code', $this->program_code);
                })
            ],
            'hoc_ky' => 'required|integer|digits_between:1,11',
            'ghi_chu' => 'max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'program_detail_subject.required' => 'Trường thông tin :attribute không được để trống',
            'program_detail_subject.notspecial_spaces' => 'Trường thông tin :attribute không chứa ký tự đặc biệt',
            'program_detail_subject.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',

            'hoc_ky.required' => 'Trường thông tin :attribute không được để trống',
            'hoc_ky.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'hoc_ky.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự',

            'ghi_chu.max' => 'Trường thông tin :attribute vượt quá 100 ký tự',
        ];
    }
}
