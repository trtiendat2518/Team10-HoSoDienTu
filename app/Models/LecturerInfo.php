<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LecturerInfo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'lecturer_faculty', 'lecturer_code', 'lecturer_avatar', 'lecturer_birthday', 'lecturer_gender', 'lecturer_phone', 'lecturer_address', 'lecturer_identify_card', 'lecturer_birth_place', 'lecturer_other_email', 'created_at', 'updated_at'
    ];
    protected $primaryKey = 'lecturer_info_id';
    protected $table = 'tbl_lecturer_info';
}
