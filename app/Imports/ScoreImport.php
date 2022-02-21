<?php

namespace App\Imports;

use App\Models\RegisterSubject;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScoreImport implements ToCollection, WithHeadingRow, WithValidation
{
    public function __construct(string $student_id)
    {
        $this->student_id = $student_id;
    }

    public function collection(Collection $rows)
    {
        $id = $this->student_id;
        foreach ($rows as $row) {
            $score = RegisterSubject::join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_subject.register_subject_student')
                ->join('tbl_program_detail', 'tbl_program_detail.program_detail_id', '=', 'tbl_register_subject.register_subject_program')
                ->join('tbl_education_program', 'tbl_education_program.education_program_code', '=', 'tbl_program_detail.program_detail_code')
                ->join('tbl_subject', 'tbl_subject.subject_code', '=', 'tbl_program_detail.program_detail_subject')
                ->where('tbl_register_subject.register_subject_student', $id)
                ->where('tbl_program_detail.program_detail_subject', $row['ma_mon_hoc'])
                ->get();
            foreach ($score as $value) {
                $value->register_subject_exercise = $row['bai_tap'];
                $value->register_subject_exam = $row['kiem_tra'];
                $value->register_subject_final = $row['thi_lan_1'];
                $value->register_subject_second = $row['thi_lan_2'];
                $value->save();
            }
        }
    }

    public function rules(): array
    {
        return [
            'ma_mon_hoc' => 'required|notspecial_spaces|max:10',
            'bai_tap' => 'required|numeric|max:11|gte:0|lte:10',
            'kiem_tra' => 'required|numeric|max:11|gte:0|lte:10',
            'thi_lan_1' => 'required|numeric|max:11|gte:0|lte:10',
            'thi_lan_2' => 'required|numeric|max:11|gte:0|lte:10',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'ma_mon_hoc.required' => 'Trường thông tin :attribute không được để trống',
            'ma_mon_hoc.notspecial_spaces' => 'Trường thông tin :attribute không được ký tự đặc biệt',
            'ma_mon_hoc.max' => 'Trường thông tin :attribute không nhập quá 10 ký tự chữ!',

            'bai_tap.required' => 'Trường thông tin :attribute không được để trống',
            'bai_tap.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự chữ!',
            'bai_tap.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'bai_tap.gte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',
            'bai_tap.lte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',

            'kiem_tra.required' => 'Trường thông tin :attribute không được để trống',
            'kiem_tra.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự chữ!',
            'kiem_tra.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'kiem_tra.gte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',
            'kiem_tra.lte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',

            'thi_lan_1.required' => 'Trường thông tin :attribute không được để trống',
            'thi_lan_1.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự chữ!',
            'thi_lan_1.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'thi_lan_1.gte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',
            'thi_lan_1.lte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',

            'thi_lan_2.required' => 'Trường thông tin :attribute không được để trống',
            'thi_lan_2.max' => 'Trường thông tin :attribute không nhập quá 11 ký tự chữ!',
            'thi_lan_2.integer' => 'Trường thông tin :attribute phải là ký tự số',
            'thi_lan_2.gte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',
            'thi_lan_2.lte' => 'Trường thông tin :attribute chỉ được nhập từ 0 đến 10!',
        ];
    }
}
