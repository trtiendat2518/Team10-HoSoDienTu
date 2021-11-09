<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'course_code', 'course_name', 'course_status'
    ];
    protected $primaryKey = 'course_id';
    protected $table = 'tbl_course';
}
