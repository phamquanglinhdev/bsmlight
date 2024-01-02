<?php
/**
 * @author Phạm Quang Linh <linhpq@getflycrm.com>
 * @since 02/01/2024 8:43 am
 */

namespace App\Helper\Object;

class CommentObject
{
    public function __construct(
        private readonly int $user_id,
        private readonly string $user_name,
        private readonly string $user_avatar,
        private readonly string $comment_time,
        private readonly int $type,
        private readonly string $content,
        private readonly bool $self
    ) {}

    public function isSelf(): bool
    {
        return $this->self;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getUserName(): string
    {
        return $this->user_name;
    }

    public function getUserAvatar(): string
    {
        return $this->user_avatar;
    }

    public function getCommentTime(): string
    {
        return $this->comment_time;
    }

    public function getType(): int
    {
        return $this->type;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
