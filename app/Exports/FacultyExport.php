<?php

namespace App\Exports;

use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class FacultyExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Faculty::all();
    }

    public function map($row): array{
           $fields = [
              $row->faculty_code,
              $row->faculty_name,
         ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã Khoa", "Tên Khoa"];
    }

    public function columnWidths(): array
    {
        return [
            'B' => 50,            
        ];
    }
}
