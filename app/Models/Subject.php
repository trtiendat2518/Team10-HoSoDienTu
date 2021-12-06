<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'subject_code', 
        'subject_name', 
        'subject_credit', 
        'subject_faculty', 
        'subject_practice_period', 
        'subject_theory_period', 
        'subject_score_exercise', 
        'subject_score_exam', 
        'subject_score_final', 
        'subject_type', 
        'subject_status'
    ];
    protected $primaryKey = 'subject_id';
    protected $table = 'tbl_subject';
}
