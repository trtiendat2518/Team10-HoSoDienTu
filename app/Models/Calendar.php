<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'title', 'body', 'category', 'start', 'end', 'calendarId', 'raw', 'location', 'recurrenceRule'
    ];
    protected $primaryKey = 'id';
    protected $table = 'tbl_calendar';
}
