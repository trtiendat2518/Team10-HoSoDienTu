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
            'ma_khoa' => 'required|notspecial_spaces|unique:tbl_faculty,faculty_code|max:3|min:2', 
            'ten_khoa' => 'required|unique:tbl_faculty,faculty_name|max:50|min:7|notspecial_spaces',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_khoa.required' => 'Mã Khoa hàng :row không được để trống',
            'ma_khoa.notspecial_spaces' => 'Mã khoa tại hàng :row không được ký tự đặc biệt',
            'ma_khoa.max' => 'Mã Khoa tại hàng :row không nhập quá 3 ký tự chữ!',
            'ma_khoa.min' => 'Mã Khoa tại hàng :row phải có 2 ký tự chữ trở lên!',
            'ma_khoa.unique' => 'Mã khoa tại hàng :row đã tồn tại',

            'ten_khoa.required' => 'Tên khoa tại hàng :row không được để trống',
            'ten_khoa.unique' => 'Tên khoa tại hàng :row đã tồn tại',
            'ten_khoa.max' => 'Tên Khoa tại hàng :row không nhập quá 50 ký tự chữ!',
            'ten_khoa.min' => 'Tên Khoa tại hàng :row phải có 7 ký tự chữ trở lên!',
            'ten_khoa.notspecial_spaces' => 'Tên khoa tại hàng :row không được ký tự đặc biệt',
        ];
    }
}
