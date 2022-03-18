<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\RegisterPlan;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class StatisticPLanExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;

    public function __construct(string $course, string $major, string $semester)
    {
        $this->course = $course;
        $this->major = $major;
        $this->semester = $semester;
    }

    public function query()
    {
        return RegisterPlan::query()->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_register_plan.register_plan_program')
            ->join('tbl_student', 'tbl_student.student_id', '=', 'tbl_register_plan.register_plan_student')
            ->select(
                'tbl_register_plan.register_plan_program',
                DB::raw('subject_name, subject_code, count(*) as total')
            )
            ->groupBy('tbl_register_plan.register_plan_program')
            ->where('tbl_student.student_course', $this->course)->where('tbl_student.student_major', $this->major)
            ->where('tbl_register_plan.register_plan_semester', $this->semester);
    }

    public function map($row): array
    {
        $fields = [
            $row->subject_code,
            $row->subject_name,
            $row->total
        ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã môn học", "Tên môn học", "Số lượng"];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 50,
            'C' => 10,
        ];
    }
}
