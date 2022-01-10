<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationProgram extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'education_program_code',
        'education_program_type',
        'education_program_course',
        'education_program_faculty',
        'education_program_year',
        'education_program_credit',
        'education_program_status'
    ];
    protected $primaryKey = 'education_program_id';
    protected $table = 'tbl_education_program';
}
