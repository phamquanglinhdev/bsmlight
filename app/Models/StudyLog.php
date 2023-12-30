<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'supportId'
    ];

    public function getSupportIdAttribute(): string
    {
        return "#".Carbon::parse($this->created_at)->timestamp;
    }

    public function getClassroomEntityAttribute(): array
    {
        return $this->Classroom()->first(['name', 'avatar', 'id', 'uuid'])->toArray();
    }

    public function Classroom(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Classroom::class, 'classroom_id', 'id');
    }
}
