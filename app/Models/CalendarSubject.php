<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarSubject extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'calendar_id',
        'subject_id',
        'calendar_subject_type',
        'calendar_subject_slot',
        'calendar_subject_registered',
        'calendar_subject_lecturer',
        'calendar_subject_day',
        'calendar_subject_time',
        'calendar_subject_start',
        'calendar_subject_end',
    ];
    protected $primaryKey = 'calendar_subject_id';
    protected $table = 'tbl_calendar_subject';
}
