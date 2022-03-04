<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterPlan extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'register_plan_student',
        'register_plan_program',
        'register_plan_semester',
        'register_plan_yearstart',
        'register_plan_yearend',
        'register_plan_date',
        'register_plan_type',
    ];
    protected $primaryKey = 'register_plan_id';
    protected $table = 'tbl_register_plan';
}
