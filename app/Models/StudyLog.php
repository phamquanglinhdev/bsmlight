<?php

namespace App\Models;

use App\Helper\Object\StudyLogAcceptedObject;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

/**
 * @property mixed $created_at
 */
class StudyLog extends Model
{
    use HasFactory;

    const DRAFT_STATUS = 0;
    # Đang nháp chưa public => CANCEL_STATUS || PROCESS_STATUS
    const PROCESS_STATUS = 1;
    # Gửi lên => những người liên quan nhận noti, vào comment, những người có quyền xác nhận vào xác nhận ()
    # => CANCEL_STATUS || Không được sửa || COMMITTED_STATUS
    const COMMITTED_STATUS = 2;
    # Đã xác nhận xong, chờ duyệt || Không một ai có quyền sửa || CANCEL_STATUS || Người có quyền chấp nhận , duyệt buổi học => ACCEPTED_STATUS || REFUSE_STATUS
    const ACCEPTED_STATUS = 3;
    # Đã duyệt xong || trừ host, không một ai có quyền tác động || Host tác động => noti cho tất cả người liên quan;
    const CANCELLED_STATUS = 4;
    const REJECTED_STATUS = 5;

    protected $table = 'studylogs';
    protected $guarded = ['id'];
    protected $appends = [
        'classroomEntity',
        'supportId',
        'week_day',
        'schedule_text'
    ];

    public function getScheduleTextAttribute(): string
    {
        if ($this->classroom_schedule_id != -1) {
            $schedule = $this->belongsTo(ClassroomSchedule::class, 'classroom_schedule_id', 'id')->first();
            if ($schedule) {
                return $schedule->start_time . " - " . $schedule->end_time;
            }
        }

        return 'Buổi học tuỳ chọn';
    }

    public function getWeekDayAttribute(): string
    {
        $studyLogDay = Carbon::parse($this->studylog_day);

        return $studyLogDay->shortEnglishDayOfWeek . ", " . $studyLogDay->format('d/m/Y');
    }

    public function getSupportIdAttribute(): string
    {
        return "#" . Carbon::parse($this->created_at)->timestamp;
    }

    public function getClassroomEntityAttribute(): array
    {
        return $this->Classroom()->first(['name', 'avatar', 'id', 'uuid'])->toArray();
    }

    public function Classroom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }

    public function StudyLogAccept(): HasMany
    {
        return $this->hasMany(StudyLogAccept::class, 'studylog_id', 'id');
    }

    public function WorkingShifts(): HasMany
    {
        return $this->hasMany(WorkingShift::class, 'studylog_id', 'id');
    }

    /**
     * @return StudyLogAcceptedObject[]
     */
    public function getAcceptedUsers(): array
    {
        $relationUsers = Collection::make();

        $this->WorkingShifts()->get()->map(function (WorkingShift $workingShift) use ($relationUsers) {
            $relationUsers[] = $workingShift->Teacher()->first();
            $relationUsers[] = $workingShift->Supporter()->first();
            $relationUsers[] = $workingShift->Staff()->first();
        });

        $this->CardLogs()->get()->map(function (CardLog $cardLog) use ($relationUsers) {
            $relationUsers[] = $cardLog->Student()->first();
        });

        $relationUsers = $relationUsers->filter(fn($item) => $item != null);


        return $relationUsers->map(function ($user) {
            $studyLogAccepts = StudyLogAccept::query()->where('studylog_id', $this->id)->where('user_id', $user->id)->first();
            if ($studyLogAccepts) {
                return new StudyLogAcceptedObject(
                    user_id : $user->id,
                    name : $user->name,
                    avatar : $user->avatar,
                    studylog_id : $this->id ?? '',
                    accepted : true,
                    accepted_time : $studyLogAccepts->accepted_time,
                    accepted_by_system : $studyLogAccepts->accepted_by_system
                );
            }

            return new StudyLogAcceptedObject(
                user_id : $user->id,
                name : $user->name,
                avatar : $user->avatar,
                studylog_id : $this->id,
                accepted : false,
                accepted_time : '',
                accepted_by_system : 0
            );
        })->toArray();
    }

    private function CardLogs(): HasMany
    {
        return $this->hasMany(CardLog::class, 'studylog_id', 'id');
    }
}
