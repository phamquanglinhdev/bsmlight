<?php

namespace App\Helper\Object;

use App\Models\Student;
use App\Models\User;

class StudyLogAcceptedObject
{
    public function __construct(
        private readonly int    $user_id,
        private readonly string $name,
        private readonly string $avatar,
        private readonly int    $studylog_id,
        private readonly bool   $accepted,
        private readonly string $accepted_time,
        private readonly int    $accepted_by_system,
        private readonly string $accepted_by,
    )
    {
    }

    public function getAcceptedBy(): string
    {
        return $this->accepted_by;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getAvatar(): string
    {
        return $this->avatar;
    }

    public function isAccepted(): bool
    {
        return $this->accepted;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getStudylogId(): int
    {
        return $this->studylog_id;
    }


    public function getAcceptedTime(): string
    {
        return $this->accepted_time;
    }

    public function getAcceptedBySystem(): int
    {
        return $this->accepted_by_system;
    }

    public function isStudent(): bool
    {
        return Student::query()->where('id',$this->user_id)->exists();
    }
}
