<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassroomShift extends Model
{
    use HasFactory;

    const TEMPLATE = [
        'start_time' => '',
        'end_time' => '',
        'teacher_id' => null,
        'supporter_id' => null,
        'room' => ''
    ];
}
