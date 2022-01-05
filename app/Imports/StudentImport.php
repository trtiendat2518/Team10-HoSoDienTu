<?php

namespace App\Imports;

use App\Models\Student;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class StudentImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row)
    {
        return new Student([
            'student_code' => $row['ma_so_sinh_vien'],
            'student_fullname' => $row['ho_va_ten'],
            'student_email' => $row['email'],
            'student_course' => $row['khoa_hoc'],
            'student_faculty' => $row['khoa'],
            'student_major' => $row['chuyen_nganh'],
            'student_class' => $row['lop_hoc'],
            'student_birthday' => $row['ngay_sinh'],
            'student_gender' => $row['gioi_tinh'],
            'student_religion' => $row['dan_toc'],
            'student_ethnic' => $row['ton_giao'],
            'student_phone' => $row['so_dien_thoai'],
            'student_address' => $row['dia_chi'],
            'student_identify_card' => $row['cmnd_cccd'],
            'student_birth_place' => $row['noi_sinh'],
            'student_country' => $row['quoc_gia'],
            'student_other_email' => $row['email_khac'],
        ]);
    }

    public function rules(): array
    {
        return [
            'ma_so_sinh_vien' => 'required|notspecial_spaces|unique:tbl_student,student_code|max:11|min:10',
            'ho_va_ten' => 'required|max:50|min:5|notspecial_spaces',
            'email' => 'required|unique:tbl_student,student_email|max:100|min:10|email',
            'khoa_hoc' => 'max:11',
            'khoa' => 'max:11',
            'chuyen_nganh' => 'max:11',
            'lop_hoc' => 'max:11',
            'ngay_sinh' => 'max:50',
            'gioi_tinh' => 'max:11',
            'dan_toc' => 'max:100',
            'ton_giao' => 'max:100',
            'so_dien_thoai' => 'max:11',
            'dia_chi' => 'max:250',
            'cmnd_cccd' => 'max:12',
            'noi_sinh' => 'max:100',
            'quoc_gia' => 'max:100',
            'email_khac' => 'max:100',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_so_sinh_vien.required' => 'Trường thông tin :attribute không được để trống',
            'ma_so_sinh_vien.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
            'ma_so_sinh_vien.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'ma_so_sinh_vien.min' => 'Trường thông tin :attribute phải có 10 ký tự trở lên!',
            'ma_so_sinh_vien.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',

            'ho_va_ten.required' => 'Trường thông tin :attribute không được để trống',
            'ho_va_ten.max' => 'Trường thông tin :attribute không nhập quá 50 ký tự chữ!',
            'ho_va_ten.min' => 'Trường thông tin :attribute phải có 5 ký tự chữ trở lên!',
            'ho_va_ten.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',

            'email.required' => 'Trường thông tin :attribute không được để trống',
            'email.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự chữ!',
            'email.min' => 'Trường thông tin :attribute phải có 10 ký tự chữ trở lên!',
            'email.email' => 'Trường thông tin :attribute sai dịnh dạng email!',
            'email.unique' => 'Trường thông tin :attribute có dữ liệu đã tồn tại',

            'khoa_hoc.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'khoa.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'chuyen_nganh.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'lop_hoc.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'ngay_sinh.max' => 'Trường thông tin :attribute không nhập quá 50 ký tự!',
            'gioi_tinh.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'dan_toc.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự!',
            'ton_giao.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự!',
            'so_dien_thoai.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự!',
            'dia_chi.max' => 'Trường thông tin :attribute không nhập quá 250 ký tự!',
            'cmnd_cccd.max' => 'Trường thông tin :attribute không nhập quá 12 ký tự!',
            'noi_sinh.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự!',
            'quoc_gia.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự!',
            'email_khac.max' => 'Trường thông tin :attribute không nhập quá 100 ký tự!',
        ];
    }
}
