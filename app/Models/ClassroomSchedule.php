<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassroomSchedule extends Model
{
    const TEMPLATE = [
        'week_day' => '',
        'start_time' => '',
        'end_time' => '',
        'shifts' => [
            [
                'start_time' => '',
                'end_time' => '',
                'teacher_id' => null,
                'supporter_id' => null,
                'room' => ''
            ]
        ]
    ];
}
