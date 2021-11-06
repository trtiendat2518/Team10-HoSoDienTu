<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'lecturer_fullname', 'lecturer_email', 'lecturer_code', 'lecturer_faculty', 'lecturer_role', 'lecturer_level', 'lecturer_status'
    ];
    protected $primaryKey = 'lecturer_id';
    protected $table = 'tbl_lecturer';
}
