<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanSuggestDetail extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'plansuggest_detail_ref', 'plansuggest_program'
    ];
    protected $primaryKey = 'plansuggest_detail_id';
    protected $table = 'tbl_plansuggest_detail';
}
