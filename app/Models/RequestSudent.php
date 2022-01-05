<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestSudent extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'request_student',
        'reqeust_title',
        'request_content',
        'request_status',
        'request_reply',
        'request_file',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'request_id';
    protected $table = 'tbl_request';
}
