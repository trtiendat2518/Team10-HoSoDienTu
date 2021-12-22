<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentInfo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'student_id_ref',
        'student_faculty',
        'student_course',
        'student_major',
        'student_class',  
        'student_avatar', 
        'student_birthday', 
        'student_gender', 
        'student_religion', 
        'student_ethnic', 
        'student_phone',
        'student_deskphone',
        'student_address', 
        'student_identify_card', 
        'student_birth_place',
        'student_country', 
        'student_other_email', 
        'created_at', 
        'updated_at'
    ];
    protected $primaryKey = 'student_info_id';
    protected $table = 'tbl_student_info';
}
