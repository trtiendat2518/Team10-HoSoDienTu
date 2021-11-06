<?php

namespace App\Imports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class FacultyImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Faculty([
            'faculty_code'=>$row['ma_khoa'],
            'faculty_name'=>$row['ten_khoa'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_khoa' => 'notspecial_spaces',
            'ma_khoa' => 'unique:tbl_faculty,faculty_code', 
            'ten_khoa' => 'unique:tbl_faculty,faculty_name',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_khoa.notspecial_spaces' => 'Mã khoa không được ký tự đặc biệt',
            'ma_khoa.unique' => 'Mã khoa tại hàng :row đã tồn tại',
            'ten_khoa.unique' => 'Tên khoa tại hàng :row đã tồn tại',
        ];
    }
}
