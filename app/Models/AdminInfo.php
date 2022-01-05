<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminInfo extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'admin_id_ref',
        'admin_avatar',
        'admin_birthday',
        'admin_gender',
        'admin_religion',
        'admin_ethnic',
        'admin_phone',
        'admin_address',
        'admin_identify_card',
        'admin_birth_place',
        'admin_country',
        'admin_other_email',
        'created_at',
        'updated_at'
    ];
    protected $primaryKey = 'admin_info_id';
    protected $table = 'tbl_admin_info';
}
