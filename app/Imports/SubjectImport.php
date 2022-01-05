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
        $fct = $this->faculty;

        return new Subject([
            'subject_code' => $row['ma_mon_hoc'],
            'subject_name' => $row['ten_mon_hoc'],
            'subject_faculty' => $fct,
            'subject_credit' => $row['tin_chi'],
            'subject_theory_period' => $row['so_gio_ly_thuyet'],
            'subject_practice_period' => $row['so_gio_thuc_hanh'],
            'subject_score_exercise' => $row['bai_tap'],
            'subject_score_exam' => $row['kiem_tra'],
            'subject_score_final' => $row['cuoi_ky'],
            'subject_type' => $row['loai_mon_hoc'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_mon_hoc' => 'required|notspecial_spaces|unique:tbl_subject,subject_code|max:10|min:2',
            'ten_mon_hoc' => 'required|unique:tbl_subject,subject_name|max:100|min:6',
            'tin_chi' => 'required|integer|digits_between:1,11',
            'so_gio_ly_thuyet' => 'required|integer|digits_between:1,11',
            'so_gio_thuc_hanh' => 'required|integer|digits_between:1,11',
            'bai_tap' => 'required|integer|digits_between:1,11',
            'kiem_tra' => 'required|integer|digits_between:1,11',
            'cuoi_ky' => 'required|integer|digits_between:1,11',
            'loai_mon_hoc' => 'required|boolean',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_mon_hoc.required' => 'Trường thông tin :attribute không được để trống',
            'ma_mon_hoc.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
            'ma_mon_hoc.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',
            'ma_mon_hoc.max' => 'Trường thông tin :attribute không nhập quá 10 ký tự chữ!',
            'ma_mon_hoc.min' => 'Trường thông tin :attribute phải có 2 ký tự chữ trở lên!',

            'ten_mon_hoc.required' => 'Trường thông tin :attribute không được để trống',
            'ten_mon_hoc.unique' => 'Trường thông tin :attribute đã có dữ liệu đã tồn tại',
            'ten_mon_hoc.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự chữ!',
            'ten_mon_hoc.min' => 'Trường thông tin :attribute phải có 6 ký tự chữ trở lên!',

            'tin_chi.required' => 'Trường thông tin :attribute không được để trống',
            'tin_chi.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'tin_chi.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',

            'so_gio_ly_thuyet.required' => 'Trường thông tin :attributekhông được để trống',
            'so_gio_ly_thuyet.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'so_gio_ly_thuyet.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',

            'so_gio_thuc_hanh.required' => 'Trường thông tin :attribute không được để trống',
            'so_gio_thuc_hanh.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'so_gio_thuc_hanh.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',

            'bai_tap.required' => 'Trường thông tin :attribute không được để trống',
            'bai_tap.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'bai_tap.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            //'bai_tap.sum' => 'Tổng trọng số phải bằng 100!',

            'kiem_tra.required' => 'Trường thông tin :attribute không được để trống',
            'kiem_tra.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'kiem_tra.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            //'kiem_tra.sum' => 'Tổng trọng số phải bằng 100!',

            'cuoi_ky.required' => 'Trường thông tin :attribute không được để trống',
            'cuoi_ky.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'cuoi_ky.digits_between' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            //'cuoi_ky.sum' => 'Tổng trọng số phải bằng 100!',

            'loai_mon_hoc.required' => 'Trường thông tin :attribute không được để trống',
            'loai_mon_hoc.boolean' => 'Trường thông tin :attribute chỉ nhập số 1 hoặc số 0',
        ];
    }
}
