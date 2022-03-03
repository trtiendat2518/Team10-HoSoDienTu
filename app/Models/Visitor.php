<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'visitor_ipaddress', 'visitor_date'
    ];
    protected $primaryKey = 'visitor_id';
    protected $table = 'tbl_visitor';
}
