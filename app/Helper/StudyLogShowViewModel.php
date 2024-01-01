<?php

namespace App\Helper;

use App\Helper\Object\CardLogObject;
use App\Helper\Object\StudyLogAcceptedObject;
use App\Helper\Object\StudyLogObject;
use App\Helper\Object\WorkingShiftObject;
use App\Models\CardLog;
use App\Models\StudyLog;
use App\Models\User;
use App\Models\WorkingShift;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Builder;

class StudyLogShowViewModel
{
    /**
     * @param StudyLog $studyLog
     * @param Collection|array $cardLogs
     * @param Collection|array $workingShifts
     * @param Collection|array $comments
     * @param StudyLogAcceptedObject[] $studyLogAcceptedUsers
     */
    public function __construct(
        private readonly StudyLog         $studyLog,
        private readonly Collection|array $cardLogs,
        private readonly Collection|array $workingShifts,
        private readonly Collection|array $comments,
        private readonly array $studyLogAcceptedUsers
    )
    {

    }

    /**
     * @return StudyLogAcceptedObject[]
     */
    public function getStudyLogAcceptedUsers(): array
    {
        return $this->studyLogAcceptedUsers;
    }

    /**
     * @return WorkingShiftObject[]
     */

    public function getWorkingShifts(): array
    {
        return $this->workingShifts->map(fn(WorkingShift $workingShift) => new WorkingShiftObject(
            id: $workingShift->id,
            start_time: $workingShift->start_time ?? '',
            end_time: $workingShift->end_time ?? '',
            room: $workingShift->room ?? '',
            teacher_id: $workingShift->teacher_id ?? '',
            supporter_id: $workingShift->supporter_id ?? '',
            staff_id: $workingShift->staff_id ?? '',
            teacher_name: $workingShift->teacher?->name ?? '',
            supporter_name: $workingShift->supporter?->name ?? '',
            staff_name: $workingShift->staff?->name ?? '',
            teacher_avatar: $workingShift->teacher?->avatar ?? '',
            supporter_avatar: $workingShift->supporter?->avatar ?? '',
            staff_avatar: $workingShift->staff?->avatar ?? '',
            teacher_comment: $workingShift->teacher_comment ?? '',
            supporter_comment: $workingShift->supporter_comment ?? '',
            teacher_timestamp: $workingShift->teacher_timestamp ?? '',
            supporter_timestamp: $workingShift->supporter_timestamp ?? '',
        ))->toArray();
    }

    /**
     * @return CardLogObject[]
     */
    public function getCardLogs(): array
    {
        return $this->cardLogs->map(fn(CardLog $cardLog) => new CardLogObject(
            id: $cardLog->card->id ?? '',
            uuid: $cardLog->card?->uuid ?? '',
            studentName: $cardLog->student->name ?? '',
            studentUuid: $cardLog->student->uuid ?? '',
            studentAvatar: $cardLog->student->avatar ?? '',
            status_text: $cardLog->StatusList()[$cardLog->status] ?? '',
            day: $cardLog->day ?? '',
            teacher_comment: $cardLog->teacher_note ?? '',
            supporter_comment: $cardLog->supporter_note ?? '',
        ))->toArray();
    }

    /**
     * @return StudyLogObject
     */

    public function getStudyLog(): StudyLogObject
    {
        $studyLog = $this->studyLog;

        return new StudyLogObject(
            title: $studyLog->title ?? '',
            status_text: "Bản nháp, chưa gửi lên",
            classroomName: $studyLog->classroom->name ?? '',
            classroomUuid: $studyLog->classroom->uuid ?? '',
            classroomAvatar: $studyLog->classroom->avatar ?? '',
            week_day: $studyLog['week_day'] ?? '',
            schedule_text: $studyLog->schedule_text ?? 'Buổi học tuỳ chọn',
            link: $studyLog->link ?? '',
            photo: $studyLog->photo ?? '',
            video: $studyLog->video ?? '',
            studylog_image: $studyLog->studylog_image ?? '',
            notes: $studyLog->notes ?? ''
        );
    }
}
