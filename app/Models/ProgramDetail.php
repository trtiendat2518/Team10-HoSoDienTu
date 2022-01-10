<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'program_detail_code',
        'program_detail_subject',
        'program_detail_semester',
        'program_detail_note',
        'program_detail_calendar',
        'program_detail_lecturer',
        'program_detail_start',
        'program_detail_end'
    ];
    protected $primaryKey = 'program_detail_id';
    protected $table = 'tbl_program_detail';
}
