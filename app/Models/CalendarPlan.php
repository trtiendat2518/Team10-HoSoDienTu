<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CalendarPlan extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'calendar_id', 'calendar_plan_subject'
    ];
    protected $primaryKey = 'calendar_plan_id';
    protected $table = 'tbl_calendar_plan';
}
