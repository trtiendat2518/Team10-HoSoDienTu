<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_code', 'student_fullname', 'student_email', 'student_status'
    ];
    protected $primaryKey = 'student_id';
    protected $table = 'tbl_student';
}
