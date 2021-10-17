<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'lecturer_fullname', 'lecturer_email', 'lecturer_provider'
    ];
    protected $primaryKey = 'lecturer_id';
    protected $table = 'tbl_lecturer';
}
