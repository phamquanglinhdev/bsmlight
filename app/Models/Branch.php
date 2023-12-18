<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property mixed $uuid
 * @property mixed $last_active
 * @property mixed $created_at
 */
class Branch extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'branches';
    protected $guarded = ['id'];

    protected $appends = [
        'total_student',
        'total_classroom',
        'total_staff',
        'total_teacher',
        'total_supporter',
        'total_studylog',
        'earned',
        'created',
        'last_active_time',
        'total_minutes'
    ];

    public function getTotalMinutesAttribute(): float
    {
        return 3100;
    }

    public function getCreatedAttribute(): string
    {
        return Carbon::parse($this->created_at)->isoFormat('DD/MM/YYYY');
    }

    public function getLastActiveTimeAttribute(): string
    {
        return Carbon::parse($this->last_active)->isoFormat("D/M/Y HH:mm");
    }

    public function getEarnedAttribute(): float
    {
        return 100000000;
    }

    public function getTotalStudentAttribute(): int
    {
        return Student::query()->withoutGlobalScope('branch')->where('branch', $this->uuid)->count();
    }

    public function getTotalClassroomAttribute(): int
    {
        return Student::query()->where('branch', $this->uuid)->count();
    }

    public function getTotalStaffAttribute(): int
    {
        return Student::query()->where('branch', $this->uuid)->count();
    }

    public function getTotalTeacherAttribute(): int
    {
        return Student::query()->where('branch', $this->uuid)->count();
    }

    public function getTotalSupporterAttribute(): int
    {
        return Student::query()->where('branch', $this->uuid)->count();
    }

    public function getTotalStudyLogAttribute(): int
    {
        return Student::query()->where('branch', $this->uuid)->count();
    }

    public static function createNewUuid(): string
    {
        $latestId = Branch::query()->latest('id')->first()?->id ?? 0;

        $uuid = $latestId < 1000
            ? sprintf('%04d', $latestId + 1)
            : sprintf('%07d', $latestId + 1);
        return "BSM-CN." . $uuid;
    }
}
