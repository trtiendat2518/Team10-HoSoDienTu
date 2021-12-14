<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormTeacher extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'form_teacher_lecturer', 'form_teacher_class', 'form_teacher_status'
    ];
    protected $primaryKey = 'form_teacher_id';
    protected $table = 'tbl_form_teacher';
}
