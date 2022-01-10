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
            'faculty_code' => $row['ma_khoa'],
            'faculty_name' => $row['ten_khoa'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_khoa' => 'required|notspecial_spaces|unique:tbl_faculty,faculty_code|max:3|min:2',
            'ten_khoa' => 'required|unique:tbl_faculty,faculty_name|max:50|min:7|notspecial_spaces',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_khoa.required' => 'Trường thông tin :attribute không được để trống',
            'ma_khoa.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
            'ma_khoa.max' => 'Trường thông tin :attribute không nhập quá 3 ký tự chữ!',
            'ma_khoa.min' => 'Trường thông tin :attribute phải có 2 ký tự chữ trở lên!',
            'ma_khoa.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',

            'ten_khoa.required' => 'Trường thông tin :attribute không được để trống',
            'ten_khoa.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',
            'ten_khoa.max' => 'Trường thông tin :attribute không nhập quá 50 ký tự chữ!',
            'ten_khoa.min' => 'Trường thông tin :attribute phải có 7 ký tự chữ trở lên!',
            'ten_khoa.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
        ];
    }
}
