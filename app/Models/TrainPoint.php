<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainPoint extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'train_point_student',
        'train_point_semester',
        'train_point_one',
        'train_point_two',
        'train_point_three',
        'train_point_four',
        'train_point_five',
        'train_point_type',
        'train_point_date'
    ];
    protected $primaryKey = 'train_point_id';
    protected $table = 'tbl_train_point';
}
