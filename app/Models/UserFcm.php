<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserFcm extends Model
{
    use HasFactory;

    protected $table = 'user_fcm';
    protected $guarded = ['id'];
}
