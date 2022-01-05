<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassStudent extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'class_name', 'class_form_teacher', 'class_course', 'class_faculty', 'class_major', 'class_status'
    ];
    protected $primaryKey = 'class_id';
    protected $table = 'tbl_class';
}
