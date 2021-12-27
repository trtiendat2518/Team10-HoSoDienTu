<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_code', 
        'student_fullname', 
        'student_email',
        'student_course',
        'student_faculty',
        'student_major',
        'student_class',  
        'student_avatar', 
        'student_birthday', 
        'student_gender', 
        'student_religion', 
        'student_ethnic', 
        'student_phone',
        'student_address', 
        'student_identify_card', 
        'student_birth_place',
        'student_country', 
        'student_other_email', 
        'student_role', 
        'student_status'
    ];
    protected $primaryKey = 'student_id';
    protected $table = 'tbl_student';
}
