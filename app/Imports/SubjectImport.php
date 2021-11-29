<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(int $faculty)
    {
        $this->faculty = $faculty;
    }

    public function model(array $row)
    {   
        if($row['loai_mon_hoc'] == 'Có'){
            $row['loai_mon_hoc'] = 0;
        }else{
            $row['loai_mon_hoc'] = 1;
        }

        
        $row['thuoc_khoa'] = $this->faculty;
        
        return new Subject([
            'subject_code'=>$row['ma_mon_hoc'],
            'subject_name'=>$row['ten_mon_hoc'],
            'subject_faculty'=>$row['thuoc_khoa'],
            'subject_credit'=>$row['tin_chi'],
            'subject_theory_period'=>$row['so_gio_ly_thuyet'],
            'subject_practice_period'=>$row['so_gio_thuc_hanh'],
            'subject_type'=>$row['loai_mon_hoc'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_mon_hoc' => 'required|notspecial_spaces|unique:tbl_subject,subject_code', 
            'ten_mon_hoc' => 'required|unique:tbl_subject,subject_name',
            'tin_chi' => 'required|numeric',
            'so_gio_ly_thuyet' => 'required|numeric',
            'so_gio_thuc_hanh' => 'required|numeric',
            'loai_mon_hoc' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_mon_hoc.required' => 'Mã môn học hàng :row không được để trống',
            'ma_mon_hoc.notspecial_spaces' => 'Mã môn học tại hàng :row không được ký tự đặc biệt',
            'ma_mon_hoc.unique' => 'Mã môn học tại hàng :row đã tồn tại',

            'ten_mon_hoc.required' => 'Tên Môn học tại hàng :row không được để trống',
            'ten_mon_hoc.unique' => 'Tên Môn học tại hàng :row đã tồn tại',

            'tin_chi.required' => 'Tín chỉ Môn học tại hàng :row không được để trống',
            'tin_chi.numeric' => 'Tín chỉ Môn học tại hàng :row phải là ký tự số',

            'so_gio_ly_thuyet.required' => 'Số tiết lý thuyết tại hàng :row không được để trống',
            'so_gio_ly_thuyet.numeric' => 'Số tiết lý thuyết tại hàng :row phải là ký tự số',

            'so_gio_thuc_hanh.required' => 'Số tiết thực hành tại hàng :row không được để trống',
            'so_gio_thuc_hanh.numeric' => 'Số tiết thực hành tại hàng :row phải là ký tự số',

            'loai_mon_hoc.required' => 'Loại Môn học tại hàng :row không được để trống',
        ];
    }
}
