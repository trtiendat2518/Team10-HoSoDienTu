<?php

namespace App\Imports;

use App\Models\Major;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class MajorImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new Major([
            'major_code' => $row['ma_chuyen_nganh'],
            'major_name' => $row['ten_chuyen_nganh'],
            'major_faculty' => $row['ma_khoa'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_chuyen_nganh' => 'required|notspecial_spaces|unique:tbl_major,major_code|max:10|min:2',
            'ten_chuyen_nganh' => 'required|unique:tbl_major,major_name|max:50|min:5|notspecial_spaces',
            'ma_khoa' => 'required|max:3',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_chuyen_nganh.required' => 'Trường thông tin :attribute không được để trống',
            'ma_chuyen_nganh.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
            'ma_chuyen_nganh.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',
            'ma_chuyen_nganh.max' => 'Trường thông tin :attribute không nhập quá 10 ký tự chữ!',
            'ma_chuyen_nganh.min' => 'Trường thông tin :attribute phải có 2 ký tự chữ trở lên!',

            'ten_chuyen_nganh.required' => 'Trường thông tin :attribute không được để trống',
            'ten_chuyen_nganh.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',
            'ten_chuyen_nganh.max' => 'Trường thông tin :attribute không nhập quá 50 ký tự chữ!',
            'ten_chuyen_nganh.min' => 'Trường thông tin :attribute phải có 5 ký tự chữ trở lên!',
            'ten_chuyen_nganh.notspecial_spaces' => 'Trường thông tin :attribute không được chứa ký tự đặc biệt!',

            'ma_khoa.required' => 'Trường thông tin :attribute không được để trống',
            'ma_khoa.max' => 'Trường thông tin :attribute không nhập quá 3 ký tự'
        ];
    }
}
