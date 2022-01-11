<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSuggest extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'plan_suggest_class', 'plan_suggest_student', 'plan_suggest_status', 'plan_suggest_lecturer'
    ];
    protected $primaryKey = 'plan_suggest_id';
    protected $table = 'tbl_plan_suggest';
}
