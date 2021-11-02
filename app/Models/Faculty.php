<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faculty extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'faculty_code', 'faculty_name', 'faculty_status'
    ];
    protected $primaryKey = 'faculty_id';
    protected $table = 'tbl_faculty';
}
