<?php

namespace App\Imports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class SubjectImport implements ToModel, WithHeadingRow, WithValidation
{
    public function __construct(string $faculty)
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
        
        $fct = $this->faculty;
        
        return new Subject([
            'subject_code'=>$row['ma_mon_hoc'],
            'subject_name'=>$row['ten_mon_hoc'],
            'subject_faculty'=>$fct,
            'subject_credit'=>$row['tin_chi'],
            'subject_theory_period'=>$row['so_gio_ly_thuyet'],
            'subject_practice_period'=>$row['so_gio_thuc_hanh'],
            'subject_score_exercise'=>$row['bai_tap'],
            'subject_score_exam'=>$row['kiem_tra'],
            'subject_score_final'=>$row['cuoi_ky'],
            'subject_type'=>$row['loai_mon_hoc'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_mon_hoc' => 'required|notspecial_spaces|unique:tbl_subject,subject_code|max:10|min:2', 
            'ten_mon_hoc' => 'required|unique:tbl_subject,subject_name|max:100|min:6',
            'tin_chi' => 'required|numeric',
            'so_gio_ly_thuyet' => 'required|numeric|max:11',
            'so_gio_thuc_hanh' => 'required|numeric|max:11',
            'bai_tap' => 'required|numeric|max:11|sum:100,subject_score_exam,subject_score_final',
            'kiem_tra' => 'required|numeric|max:11|sum:100,subject_score_exam,subject_score_final',
            'cuoi_ky' => 'required|numeric|max:11|sum:100,subject_score_exam,subject_score_final',
            'loai_mon_hoc' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_mon_hoc.required' => 'Mã môn học hàng :row không được để trống',
            'ma_mon_hoc.notspecial_spaces' => 'Mã môn học tại hàng :row không được ký tự đặc biệt',
            'ma_mon_hoc.unique' => 'Mã môn học tại hàng :row đã tồn tại',
            'ma_mon_hoc.max' => 'Mã Môn học tại hàng :row không nhập quá 10 ký tự chữ!',
            'ma_mon_hoc.min' => 'Mã Môn học tại hàng :row phải có 2 ký tự chữ trở lên!',

            'ten_mon_hoc.required' => 'Tên Môn học tại hàng :row không được để trống',
            'ten_mon_hoc.unique' => 'Tên Môn học tại hàng :row đã tồn tại',
            'ten_mon_hoc.max' => 'Tên Môn học tại hàng :row không nhập quá 100 ký tự chữ!',
            'ten_mon_hoc.min' => 'Tên Môn học tại hàng :row phải có 6 ký tự chữ trở lên!',

            'tin_chi.required' => 'Tín chỉ Môn học tại hàng :row không được để trống',
            'tin_chi.numeric' => 'Tín chỉ Môn học tại hàng :row phải là ký tự số',

            'so_gio_ly_thuyet.required' => 'Số tiết lý thuyết tại hàng :row không được để trống',
            'so_gio_ly_thuyet.numeric' => 'Số tiết lý thuyết tại hàng :row phải là ký tự số',
            'so_gio_ly_thuyet.max' => 'Số giờ lý thuyết tại hàng :row không nhập quá 11 ký tự số!',

            'so_gio_thuc_hanh.required' => 'Số tiết thực hành tại hàng :row không được để trống',
            'so_gio_thuc_hanh.numeric' => 'Số tiết thực hành tại hàng :row phải là ký tự số',
            'so_gio_thuc_hanh.max' => 'Số giờ thực hành tại hàng :row không nhập quá 11 ký tự số!',

            'bai_tap.required' => 'Trọng số bài tập tại hàng :row không được để trống',
            'bai_tap.numeric' => 'Trọng số bài tập tại hàng :row phải là ký tự số',
            'bai_tap.max' => 'Trọng số bài tập tại hàng :row không nhập quá 11 ký tự số!',
            'bai_tap.sum' => 'Tổng trọng số phải bằng 100!',

            'kiem_tra.required' => 'Trọng số kiểm tra tại hàng :row không được để trống',
            'kiem_tra.numeric' => 'Trọng số kiểm tra tại hàng :row phải là ký tự số',
            'kiem_tra.max' => 'Trọng số kiểm tra tại hàng :row không nhập quá 11 ký tự số!',
            'kiem_tra.sum' => 'Tổng trọng số phải bằng 100!',

            'cuoi_ky.required' => 'Trọng số cuối kỳ tại hàng :row không được để trống',
            'cuoi_ky.numeric' => 'Trọng số cuối kỳ tại hàng :row phải là ký tự số',
            'cuoi_ky.max' => 'Trọng số cuối kỳ tại hàng :row không nhập quá 11 ký tự số!',
            'cuoi_ky.sum' => 'Tổng trọng số phải bằng 100!',

            'loai_mon_hoc.required' => 'Loại Môn học tại hàng :row không được để trống',
        ];
    }
}
