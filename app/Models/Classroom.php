<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

/**
 * 1. Thông tin lớp:
 * - Mã lớp
 * - Tên lớp
 * 2. Ảnh
 * 3. Nhóm chat về nội dung dạy cho nội bộ
 * 4. Nhóm chat thông báo cho PH
 * 5. Nhóm chat thông báo cho HS
 * 6. Lịch học
 * - Ngày cập nhật gần nhất
 * 7. Giáo viên phụ trách
 * 8. Trợ giảng phụ trách
 * 9. Nhân viên phụ trách
 *
 * 10. Phân tích lãi lỗ (popup ra bảng lịch sử theo từng tháng)
 * - Số buổi lớp đã chạy trong tháng (số buổi điểm danh)
 * - Danh sách các ngày trong tháng (Ngày điểm danh)
 *
 * - Thống kê điểm danh (đi học/vắng, trừ/ko trừ)
 *
 * - Sĩ số hs đi học trung bình/buổi của tháng.
 * - Doanh thu thực tế (nợ phí đã trả)
 * - Giá vốn - lương giáo viên nước ngoài
 * - Giá vốn - lương giáo viên Việt Nam
 * - Giá vốn - lương trợ giảng
 * - Lãi gộp
 * - %lãi gộp
 */

/**
 * @property string $uuid # Mã lớp
 * @property string $name # Tên lớp
 * @property string $avatar #Ảnh lớp
 *
 * @property string $broadcast_chat # Nhóm chat về nội dung dạy cho nội bộ
 * @property string|null $broadcast_teacher_chat # Nhóm chat thông báo cho PH
 * @property string|null $broadcast_student_chat # Nhóm chat thông báo cho HS
 *
 * @property ClassroomSchedule[] $classroom_schedule # Lịch học
 * @property string $schedule_last_update # Ngày cập nhật gần nhất
 *
 * #Lấy từ ca học
 * @property Teacher[] $teacher # Giáo viên phụ trách
 * @property Supporter[] $supporter # Trợ giảng phụ trách
 *
 * @property Staff $staff # Nhân viên phụ trách
 *
 *
 *
 * Phân tích lãi lỗ (popup ra bảng lịch sử theo từng tháng)
 * @property int $total_meetings # Số buổi lớp đã chạy trong tháng
 * @property int $days # Danh sách các ngày trong tháng
 * @property int $student_attended # Tổng số buổi đi học của học sinh
 * @property int $student_left # Tổng số buổi vắng của học sinh
 * @property int $attendance # Sĩ số hs đi học trung bình/buổi
 * @property int $total_earned # Doanh thu thực tế
 *
 *  - Giá vốn -
 * @property int $external_salary #lương giáo viên nước ngoài
 * @property int $internal_salary #lương giáo viên Việt Nam
 * @property int $supporter_salary #lương trợ giảng
 * @property int $gross # Lãi gộp
 * @property int $gross_percent # %lãi gộp
 */
class Classroom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $table = 'classrooms';

    protected $appends = [
        'broadcast_chat',
        'broadcast_teacher_chat',
        'broadcast_student_chat',
        'classroom_schedule',
        'schedule_last_update',
        'total_meetings',
        'days',
        'student_attended',
        'student_left',
        'avg_attendance',
        'total_earned',
        'external_salary',
        'internal_salary',
        'supporter_salary',
        'gross',
        'gross_percent',
        'gross_status',
        'teachers',
        'supporters',
        'staff',
    ];

    #accessor here
    public function getBroadcastChatAttribute(): string
    {
        return 'https://google.com';
    }

    public function getBroadcastTeacherChatAttribute(): string
    {
        return 'https://google.com';
    }

    public function getBroadcastStudentChatAttribute(): string
    {
        return 'https://google.com';
    }

    public function getClassroomScheduleAttribute(): array
    {
        return ClassroomSchedule::where('classroom_id', $this->id)->get()->mapWithKeys(function (ClassroomSchedule $item) {
            return [$item->id => $item->getWeekStringAttribute() . ": " . $item->start_time . " - " . $item->end_time];
        })->all();
    }

    public function getScheduleLastUpdateAttribute(): string
    {
        return $this->created_at ?? '';
    }

    public function getTotalMeetingsAttribute(): int
    {
        return $this->StudyLogs()->count();
    }

    public function getDaysAttribute(): array
    {
        return [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30, 31];
    }


    public function getStudentAttendedAttribute(): int
    {
        $studyLogs = $this->StudyLogs()->get();
        return array_sum($studyLogs->map(function (StudyLog $studyLog) {
            return $studyLog->CardLogs()->where('status', CardLog::VERIFIED)->where('status', '<', 3)->count();

        })->toArray());

    }

    public function getStudentLeftAttribute(): int
    {
        $studyLogs = $this->StudyLogs()->get();
        return array_sum($studyLogs->map(function (StudyLog $studyLog) {
            return $studyLog->CardLogs()->where('status', CardLog::VERIFIED)->where('status', '>', 3)->count();

        })->toArray());
    }

    public function getAvgAttendanceAttribute(): float
    {
        if ($this->getStudentLeftAttribute() == 0) {
            return 0;
        }
        return $this->getStudentAttendedAttribute() / ($this->getStudentAttendedAttribute() + $this->getStudentLeftAttribute());
    }

    public function getTotalEarnedAttribute(): int
    {
        return array_sum($this->StudyLogs()->get()->map(function (StudyLog $studyLog) {
            return $studyLog->CardLogs()->where('status', CardLog::VERIFIED)->sum('fee');
        })->toArray());
    }

    public function getExternalSalaryAttribute(): int
    {
        #TODO Bổ sung thẻ lương giáo viên

//        $totalStudyLog = $this->StudyLogs()->get()->map(function (StudyLog $studyLog) {
//            return $studyLog->WorkingShifts()->first()->Teachers();
//        });

        return 0;
    }

    public function getInternalSalaryAttribute(): int
    {
        #TODO Bổ sung thẻ lương giáo viên
        return 0;
    }

    public function getSupporterSalaryAttribute(): int
    {
        #TODO Bổ sung thẻ lương
        return 0;
    }

    public function getGrossAttribute(): int
    {
        return $this->total_earned - $this->external_salary - $this->internal_salary - $this->supporter_salary;
    }

    public function getGrossPercentAttribute(): float|int
    {
        if ($this->total_earned == 0) {
            return 0;
        }
        return $this->gross / $this->total_earned * 100;
    }

    /**
     * @return string
     * %Gross :
     * Tình trạng lớp:
     * < 0 = SOS (màu đỏ sẫm
     * Từ 0->15% = A (màu đỏ)
     * Từ 16->30% = B (màu đỏ nhạt)
     * Từ 31%->45% = C (màu xanh lá cây nhạt)
     * Từ 46->60% = D (màu xanh lá)
     * Trên 60% = E (màu tím)
     */
    public function getGrossStatusAttribute(): string
    {
        if ($this->gross_percent < 0) {
            return 'SOS';
        }

        if ($this->gross_percent > 0 && $this->gross_percent <= 15) {
            return 'A';
        }

        if ($this->gross_percent > 15 && $this->gross_percent <= 30) {
            return 'B';
        }

        if ($this->gross_percent > 30 && $this->gross_percent <= 45) {
            return 'C';
        }

        if ($this->gross_percent > 45 && $this->gross_percent <= 60) {
            return 'D';
        }

        if ($this->gross_percent > 60) {
            return 'E';
        }

        return 'SOS';
    }

    public function getTeachersAttribute()
    {
        return null;
    }

    public function getSupportersAttribute()
    {
        return null;
    }

    public function getStaffAttribute()
    {
        return null;
    }

    public static function generateUUID(): string
    {
        $classroomId = Classroom::query()->orderBy('id', 'desc')->first()?->id ?? 0;

        $classroomNewId = $classroomId < 1000 ? sprintf('%04d', $classroomId + 1) : sprintf('%07d', $classroomId + 1);

        return Auth::user()->{'branch'} . "-" . "Lop" . "." . $classroomNewId;
    }

    public function Cards(): HasMany
    {
        return $this->hasMany(Card::class, 'classroom_id', 'id');
    }

    public function Schedules(): HasMany
    {
        return $this->hasMany(ClassroomSchedule::class, 'classroom_id', 'id');
    }

    public function SchedulesFormat()
    {
        return $this->Schedules()->get()->map(function (ClassroomSchedule $schedule) {
            return [
                'week_day' => $schedule->week_day,
                'start_time' => $schedule->start_time,
                'end_time' => $schedule->end_time,
                'shifts' => $schedule->Shifts()->get()->map(function ($shift) {
                    return [
                        'start_time' => $shift->start_time,
                        'end_time' => $shift->end_time,
                        'teacher_id' => $shift->teacher_id,
                        'supporter_id' => $shift->supporter_id,
                        'room' => $shift->room
                    ];
                })->toArray()
            ];
        });

    }

    public function Shifts(): HasMany
    {
        return $this->hasMany(ClassroomShift::class, 'classroom_id', 'id');
    }

    public function Staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id', 'id');
    }

    public static function boot(): void
    {
        parent::boot();

        if (Auth::user()->role != User::HOST_ROLE) {
            static::addGlobalScope('relation', function (Builder $builder) {
                $builder->where(function ($builder) {
                    $builder->where('staff_id', Auth::id())->orWhere(function ($builder) {
                        $builder->whereHas('Shifts', function (Builder $shift) {
                            $shift->where('supporter_id', Auth::id())->orWhere('teacher_id', Auth::id());
                        });
                    })->orWhereHas('Cards', function (Builder $card) {
                        $card->where('student_id', Auth::id());
                    });
                });
            });
        } else {
            static::addGlobalScope('relation', function (Builder $builder) {
                $builder->where('branch', Auth::user()->{'branch'});
            });
        }


    }

    public function StudyLogs(): HasMany
    {
        return $this->hasMany(StudyLog::class, 'classroom_id', 'id')->where('status', StudyLog::ACCEPTED_STATUS);
    }
}
