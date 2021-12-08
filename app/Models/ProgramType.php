<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramType extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'program_type_name', 'program_type_code', 'program_type_status'
    ];
    protected $primaryKey = 'program_type_id';
    protected $table = 'tbl_program_type';
}
