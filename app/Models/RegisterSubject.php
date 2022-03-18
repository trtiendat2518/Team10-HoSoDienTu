<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterSubject extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'register_subject_student',
        'register_subject_program',
        'register_subject_exercise',
        'register_subject_exam',
        'register_subject_final',
        'register_subject_yearstart',
        'register_subject_yearend',
        'register_subject_date',
        'register_subject_again',
    ];
    protected $primaryKey = 'register_subject_id';
    protected $table = 'tbl_register_subject';
}
