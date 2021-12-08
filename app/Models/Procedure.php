<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'procedure_title', 
        'procedure_content', 
        'procedure_time', 
        'procedure_method', 
        'procedure_fee', 
        'procedure_category',
        'procedure_status'
    ];
    protected $primaryKey = 'procedure_id';
    protected $table = 'tbl_procedure';
}
