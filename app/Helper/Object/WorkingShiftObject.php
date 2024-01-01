<?php

namespace App\Helper\Object;

class WorkingShiftObject
{
    public function __construct(
        private readonly int $id,
        private readonly string $start_time,
        private readonly string $end_time,
        private readonly string $room,
        private readonly int $teacher_id,
        private readonly int $supporter_id,
        private readonly int $staff_id,
        private readonly string $teacher_name,
        private readonly string $supporter_name,
        private readonly string $staff_name,
        private readonly string $teacher_avatar,
        private readonly string $supporter_avatar,
        private readonly string $staff_avatar,
        private readonly string $teacher_comment,
        private readonly string $supporter_comment,
        private readonly string $teacher_timestamp,
        private readonly string $supporter_timestamp,

    ){

    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStartTime(): string
    {
        return $this->start_time;
    }

    public function getEndTime(): string
    {
        return $this->end_time;
    }

    public function getRoom(): string
    {
        return $this->room;
    }

    public function getTeacherId(): int
    {
        return $this->teacher_id;
    }

    public function getSupporterId(): int
    {
        return $this->supporter_id;
    }

    public function getStaffId(): int
    {
        return $this->staff_id;
    }

    public function getTeacherName(): string
    {
        return $this->teacher_name;
    }

    public function getSupporterName(): string
    {
        return $this->supporter_name;
    }

    public function getStaffName(): string
    {
        return $this->staff_name;
    }

    public function getTeacherAvatar(): string
    {
        return $this->teacher_avatar;
    }

    public function getSupporterAvatar(): string
    {
        return $this->supporter_avatar;
    }

    public function getStaffAvatar(): string
    {
        return $this->staff_avatar;
    }

    public function getTeacherComment(): string
    {
        return $this->teacher_comment;
    }

    public function getSupporterComment(): string
    {
        return $this->supporter_comment;
    }

    public function getTeacherTimestamp(): string
    {
        return $this->teacher_timestamp;
    }

    public function getSupporterTimestamp(): string
    {
        return $this->supporter_timestamp;
    }
}
