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
                return 'Thứ hai';
            case 3:
                return 'Thứ ba';
            case 4:
                return 'Thứ tư';
            case 5:
                return 'Thứ năm';
            case 6:
                return 'Thứ sáu';
            case 7:
                return 'Thứ bày';
            case 8:
                return 'Chủ nhật';
        }
        return '';
    }

    public function Shifts(): HasMany
    {
        return $this->hasMany(ClassroomShift::class, 'classroom_schedule_id', 'id');
    }
}
