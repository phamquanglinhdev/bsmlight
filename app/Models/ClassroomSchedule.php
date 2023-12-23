<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    protected $table = 'classroom_schedules';
    protected $guarded = ['id'];

    public function getWeekStringAttribute()
    {
        switch ($this->week_day) {
            case 2:
                return 'Monday';
            case 3:
                return 'Tuesday';
            case 4:
                return 'Wednesday';
            case 5:
                return 'Thursday';
            case 6:
                return 'Friday';
            case 7:
                return 'Saturday';
            case 8:
                return 'Sunday';
        }
        return '';
    }

    public function Shifts(): HasMany
    {
        return $this->hasMany(ClassroomShift::class, 'classroom_schedule_id', 'id');
    }
}
