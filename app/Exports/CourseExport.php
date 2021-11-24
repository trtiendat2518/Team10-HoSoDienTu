<?php

namespace App\Exports;

use App\Models\Course;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CourseExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Course::all();
    }

    public function map($row): array{
           $fields = [
              $row->course_code,
              $row->course_name,
         ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã Khóa học", "Tên Khóa học"];
    }

    public function columnWidths(): array
    {
        return [   
            'B' => 50,            
        ];
    }
}
