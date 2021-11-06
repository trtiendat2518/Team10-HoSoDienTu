<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'major_code', 'major_name', 'major_faculty', 'major_status'
    ];
    protected $primaryKey = 'major_id';
    protected $table = 'tbl_major';
}
