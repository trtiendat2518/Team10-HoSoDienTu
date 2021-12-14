<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureRequire extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'procedure_require_code', 
        'procedure_require_detail', 
        'procedure_require_datesend', 
        'procedure_require_dateget', 
        'procedure_require_status', 
        'procedure_require_student',
    ];
    protected $primaryKey = 'procedure_require_id';
    protected $table = 'tbl_procedure_require';
}
