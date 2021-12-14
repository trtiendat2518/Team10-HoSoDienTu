<?php

namespace App\Imports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CourseImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Course([
            'course_code'=>$row['ma_khoa_hoc'],
            'course_name'=>$row['ten_khoa_hoc'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_khoa_hoc' => 'required|notspecial_spaces|unique:tbl_course,course_code|max:3|min:2', 
            'ten_khoa_hoc' => 'required|unique:tbl_course,course_name|max:50|min:5|notspecial_spaces',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_khoa_hoc.required' => 'Mã Khóa Học hàng :row không được để trống',
            'ma_khoa_hoc.notspecial_spaces' => 'Mã Khóa Học tại hàng :row không được ký tự đặc biệt',
            'ma_khoa_hoc.unique' => 'Mã Khóa Học tại hàng :row đã tồn tại',
            'ma_khoa_hoc.max' => 'Mã Khóa Học tại hàng :row không nhập quá 3 ký tự chữ!',
            'ma_khoa_hoc.min' => 'Mã Khóa Học tại hàng :row phải có 2 ký tự chữ trở lên!',

            'ten_khoa_hoc.required' => 'Tên Khóa Học tại hàng :row không được để trống',
            'ten_khoa_hoc.unique' => 'Tên Khóa Học tại hàng :row đã tồn tại',
            'ten_khoa_hoc.max' => 'Tên Khóa Học tại hàng :row không nhập quá 50 ký tự chữ!',
            'ten_khoa_hoc.min' => 'Tên Khóa Học tại hàng :row phải có 5 ký tự chữ trở lên!',
            'ten_khoa_hoc.notspecial_spaces' => 'Tên Khóa Học tại hàng :row không được chứa ký tự đặc biệt!',
        ];
    }
}
