<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarExam extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'calendar_exam_schedule',
        'calendar_exam_faculty',
        'calendar_exam_course',
        'calendar_exam_faculty',
        'calendar_exam_major',
        'calendar_exam_room',
        'calendar_exam_method',
        'calendar_exam_semester',
        'calendar_exam_place',
        'calendar_exam_note'
    ];
    protected $primaryKey = 'calendar_exam_id';
    protected $table = 'tbl_calendar_exam';
}
