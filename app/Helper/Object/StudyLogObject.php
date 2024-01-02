<?php
namespace App\Helper\Object;
class StudyLogObject
{
    public function __construct(
        private readonly int $id,
        private readonly string $title,
        private readonly string $status_text,
        private readonly string $classroomName,
        private readonly string $classroomUuid,
        private readonly string $classroomAvatar,
        private readonly string $week_day,
        private readonly string $schedule_text,
        private readonly string $link,
        private readonly string $photo,
        private readonly string $video,
        private readonly string $studylog_image,
        private readonly string $notes,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getStatusText(): string
    {
        return $this->status_text;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getClassroomName(): string
    {
        return $this->classroomName;
    }

    public function getClassroomUuid(): string
    {
        return $this->classroomUuid;
    }

    public function getClassroomAvatar(): string
    {
        return $this->classroomAvatar;
    }

    public function getWeekDay(): string
    {
        return $this->week_day;
    }

    public function getScheduleText(): string
    {
        return $this->schedule_text;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function getPhoto(): string
    {
        return $this->photo;
    }

    public function getVideo(): string
    {
        return $this->video;
    }

    public function getStudylogImage(): string
    {
        return $this->studylog_image;
    }

    public function getNotes(): string
    {
        return $this->notes;
    }
}
