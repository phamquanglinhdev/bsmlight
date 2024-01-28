<?php

namespace App\Helper\Object;

class NotificationObject
{
    public function __construct(
        private readonly string $title,
        private readonly string $body,
        private readonly array $user_ids,
        private readonly ?string $thumbnail,
        private readonly ?string $ref,
        private readonly ?array $attributes,
    )
    {
    }

    public function getUserIds(): array
    {
        return $this->user_ids;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }
}
