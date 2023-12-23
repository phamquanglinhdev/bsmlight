<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkingShift extends Model
{
    use HasFactory;

    public const TEMPLATE = [
        'teacher_id' => '',
        'supporter_id' => '',
        'start_time' => '',
        'end_time' => '',
        'room' => '',
        'teacher_timestamp' => '',
        'supporter_timestamp' => '',
        'teacher_comment' => '',
        'supporter_comment' => '',
    ];
}
