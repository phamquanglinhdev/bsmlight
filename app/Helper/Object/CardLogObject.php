<?php

namespace App\Helper\Object;

class CardLogObject
{
    public function __construct(
        private readonly string  $id,
        private readonly string  $uuid,
        private readonly string  $studentName,
        private readonly string  $studentUuid,
        private readonly string  $studentAvatar,
        private readonly string  $status_text,
        private readonly bool $day,
        private readonly string  $teacher_comment,
        private readonly string  $supporter_comment
    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getStudentName(): string
    {
        return $this->studentName;
    }

    public function getStudentUuid(): string
    {
        return $this->studentUuid;
    }

    public function getStudentAvatar(): string
    {
        return $this->studentAvatar;
    }

    public function getStatusText(): string
    {
        return $this->status_text;
    }

    public function getDay(): bool
    {
        return $this->day;
    }

    public function getTeacherComment(): string
    {
        return $this->teacher_comment;
    }

    public function getSupporterComment(): string
    {
        return $this->supporter_comment;
    }
}
