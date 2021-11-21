<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'post_title', 'post_content', 'post_author', 'post_status', 'post_date'
    ];
    protected $primaryKey = 'post_id';
    protected $table = 'tbl_post';
}
