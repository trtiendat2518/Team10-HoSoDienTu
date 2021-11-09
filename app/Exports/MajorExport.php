<?php

namespace App\Exports;

use App\Models\Major;
use App\Models\Faculty;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class MajorExport implements FromCollection, WithHeadings, WithMapping, WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Major::all();
    }

    public function map($row): array{
        $fields = [
            $row->major_code,
            $row->major_name,
            $row->major_faculty,
        ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã Chuyên Ngành", "Tên Chuyên Ngành", "Mã Khoa"];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 50,
            'B' => 50, 
            'C' => 30,            
        ];
    }
}
