<?php

namespace App\Exports;

use App\Models\Subject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class SubjectExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths
{
    use Exportable;

    public function __construct(int $faculty)
    {
        $this->faculty = $faculty;
    }

    public function query()
    {
        return Subject::query()->where('subject_faculty', $this->faculty);
    }

    public function map($row): array{
        if ($row->subject_type==0) {
            $row->subject_type = 'Bắt buộc';
        }else {
            $row->subject_type = 'Tự chọn';
        }
        $fields = [
            $row->subject_code,
            $row->subject_name,
            $row->subject_credit,
            $row->subject_theory_period,
            $row->subject_practice_period,
            $row->subject_type
        ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã môn học", "Tên môn học", "Tín chỉ", "Số tiết lý thuyết", "Số tiết thực hành", "Loại môn học"];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 50,
            'D' => 15, 
            'E' => 15,             
        ];
    }
}
