<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'notification_title', 'notification_student', 'notification_object', 'notification_status', 'notification_date'
    ];
    protected $primaryKey = 'notification_id';
    protected $table = 'tbl_notification';
}
