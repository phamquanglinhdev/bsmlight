<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyLogAccept extends Model
{
    use HasFactory;
    protected $table = 'studylogs_accepts';
    protected $guarded = ['id'];
}
