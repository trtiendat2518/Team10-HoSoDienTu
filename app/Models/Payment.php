<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'payment_code', 'payment_student', 'payment_fee', 'payment_semester', 'payment_date'
    ];
    protected $primaryKey = 'payment_id';
    protected $table = 'tbl_payment';
}
