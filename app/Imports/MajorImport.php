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
            'major_code'=>$row['ma_chuyen_nganh'],
            'major_name'=>$row['ten_chuyen_nganh'],
            'major_faculty'=>$row['ma_khoa'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_chuyen_nganh' => 'required|notspecial_spaces|unique:tbl_major,major_code', 
            'ten_chuyen_nganh' => 'required|unique:tbl_major,major_name',
            'ma_khoa' =>'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_chuyen_nganh.required' => 'Mã chuyên ngành không được để trống',
            'ma_chuyen_nganh.notspecial_spaces' => 'Mã chuyên ngành không được ký tự đặc biệt',
            'ma_chuyen_nganh.unique' => 'Mã chuyên ngành tại hàng :row đã tồn tại',
            'ten_chuyen_nganh.required' => 'Tên chuyên ngành không được để trống',
            'ten_chuyen_nganh.unique' => 'Tên chuyên ngành tại hàng :row đã tồn tại',
            'ma_khoa.required' => 'Không được để trống Mã Khoa tại hàng :row'
        ];
    }
}
