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
            'student_code'=>$row['ma_so_sinh_vien'], 
            'student_fullname'=>$row['ho_va_ten'], 
            'student_email'=>$row['email'],
            'student_course'=>$row['khoa_hoc'],
            'student_faculty'=>$row['khoa'],
            'student_major'=>$row['chuyen_nganh'],
            'student_class'=>$row['lop_hoc'],
            'student_birthday'=>$row['ngay_sinh'], 
            'student_gender'=>$row['gioi_tinh'], 
            'student_religion'=>$row['dan_toc'], 
            'student_ethnic'=>$row['ton_giao'], 
            'student_phone'=>$row['so_dien_thoai'],
            'student_address'=>$row['dia_chi'], 
            'student_identify_card'=>$row['cmnd_cccd'], 
            'student_birth_place'=>$row['noi_sinh'],
            'student_country'=>$row['quoc_gia'], 
            'student_other_email'=>$row['email_khac'],
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
            'ma_so_sinh_vien.required' => 'Mã số sinh viên hàng :row không được để trống',
            'ma_so_sinh_vien.notspecial_spaces' => 'Mã số sinh viên tại hàng :row không được ký tự đặc biệt',
            'ma_so_sinh_vien.max' => 'Mã số sinh viên tại hàng :row không nhập quá 11 ký tự!',
            'ma_so_sinh_vien.min' => 'Mã số sinh viên tại hàng :row phải có 10 ký tự trở lên!',
            'ma_so_sinh_vien.unique' => 'Mã số sinh viên tại hàng :row đã tồn tại',

            'ho_va_ten.required' => 'Họ và tên tại hàng :row không được để trống',
            'ho_va_ten.max' => 'Họ và tên tại hàng :row không nhập quá 50 ký tự chữ!',
            'ho_va_ten.min' => 'Họ và tên tại hàng :row phải có 5 ký tự chữ trở lên!',
            'ho_va_ten.notspecial_spaces' => 'Họ và tên tại hàng :row không được ký tự đặc biệt',

            'email.required' => 'Email tại hàng :row không được để trống',
            'email.max' => 'Email tại hàng :row không nhập quá 100 ký tự chữ!',
            'email.min' => 'Email tại hàng :row phải có 10 ký tự chữ trở lên!',
            'email.email' => 'Thông tin tại hàng :row sai dịnh dạng email!',
            'email.unique' => 'Email tại hàng :row đã tồn tại',

            'khoa_hoc.max' => 'Khóa học tại hàng :row không nhập quá 11 ký tự!',
            'khoa.max' => 'Khoa tại hàng :row không nhập quá 11 ký tự!', 
            'chuyen_nganh.max' => 'Chuyên ngành tại hàng :row không nhập quá 11 ký tự!',
            'lop_hoc.max' => 'Lớp học tại hàng :row không nhập quá 11 ký tự!', 
            'ngay_sinh.max' => 'Ngày sinh tại hàng :row không nhập quá 50 ký tự!',
            'gioi_tinh.max' => 'Giới tính tại hàng :row không nhập quá 11 ký tự!',
            'dan_toc.max' => 'Dân tộc tại hàng :row không nhập quá 100 ký tự!', 
            'ton_giao.max' => 'Tôn giáo tại hàng :row không nhập quá 100 ký tự!',
            'so_dien_thoai.max' => 'Số điện thoại tại hàng :row không nhập quá 11 ký tự!', 
            'dia_chi.max' => 'Địa chỉ tại hàng :row không nhập quá 250 ký tự!',
            'cmnd_cccd.max' => 'CMND/CCCD tại hàng :row không nhập quá 12 ký tự!', 
            'noi_sinh.max' => 'Nơi sinh tại hàng :row không nhập quá 100 ký tự!',
            'quoc_gia.max' => 'Quốc gia tại hàng :row không nhập quá 100 ký tự!',
            'email_khac.max' => 'Email khác tại hàng :row không nhập quá 100 ký tự!',
        ];
    }
}
