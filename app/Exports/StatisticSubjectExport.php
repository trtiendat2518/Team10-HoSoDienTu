<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\CalendarSubject;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class StatisticSubjectExport implements FromQuery, WithHeadings, WithMapping, WithColumnWidths
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
        $get = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->where('tbl_calendar.raw', $this->course)->where('tbl_calendar.body', $this->major)
            ->where('tbl_calendar.location', $this->semester)
            ->where('tbl_calendar_subject.calendar_subject_registered', '>', 0)
            ->get();

        $joins = CalendarSubject::join('tbl_calendar', 'tbl_calendar.id', '=', 'tbl_calendar_subject.calendar_id')
            ->join('tbl_subject', 'tbl_subject.subject_id', '=', 'tbl_calendar_subject.subject_id')
            ->where('tbl_calendar.raw', $this->course)->where('tbl_calendar.body', $this->major)
            ->where('tbl_calendar.location', $this->semester)
            ->where('tbl_calendar_subject.calendar_subject_registered', '>', 0);

        foreach ($get as $key => $value) {
            $slot = $value->calendar_subject_slot - ($value->calendar_subject_slot * 0.3);
            $joins->where('tbl_calendar_subject.calendar_subject_registered', '<', $slot);
        }

        return $joins;
    }

    public function map($row): array
    {
        $fields = [
            $row->subject_code,
            $row->subject_name,
            $row->calendar_subject_slot,
            $row->calendar_subject_registered,
        ];
        return $fields;
    }

    public function headings(): array
    {
        return ["Mã môn học", "Tên môn học", "Số lượng", "Đã đăng ký"];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 50,
            'C' => 20,
            'D' => 20,
        ];
    }
}
