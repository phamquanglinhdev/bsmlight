<?php

namespace App\Helper\Object;

class TransactionObject
{
    public function __construct(
        private readonly int $id,
        private readonly string $uuid,
        private readonly string $type,
        private readonly string $note,
        private readonly int $amount,
        private readonly bool $new,
        private readonly string $accepted,
        private readonly string $created_at,
        private readonly ?string $image,
        private readonly string $creator_name,
        private readonly string $creator_uuid,
        private readonly string $creator_avatar,
        private readonly int $created_by,
    )
    {
    }

    public function getCreatorName(): string
    {
        return $this->creator_name;
    }

    public function getCreatorUuid(): string
    {
        return $this->creator_uuid;
    }

    public function getCreatorAvatar(): string
    {
        return $this->creator_avatar;
    }

    public function getCreatedBy(): int
    {
        return $this->created_by;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUuid(): string
    {
        return $this->uuid;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function isNew(): bool
    {
        return $this->new;
    }

    public function getAccepted(): string
    {
        return $this->accepted;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
