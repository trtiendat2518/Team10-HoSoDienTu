<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSecond extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'exam_second_course',
        'exam_second_major',
        'exam_second_subject',
        'exam_second_quantity'
    ];
    protected $primaryKey = 'exam_second_id';
    protected $table = 'tbl_exam_second';
}
