<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'admin_fullname', 'admin_username', 'admin_email', 'admin_password', 'last_changed_password_at', 'created_at', 'updated_at'
    ];
    protected $primaryKey = 'admin_id';
    protected $table = 'tbl_admin';
}
