<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tuition extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'tuition_course', 'tuition_faculty', 'tuition_major', 'tuition_fee', 'tuition_discount'
    ];
    protected $primaryKey = 'tuition_id';
    protected $table = 'tbl_tuition';
}
