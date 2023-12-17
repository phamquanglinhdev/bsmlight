<?php

namespace App\Helper;

class Statistic
{
    use BaseObject;

    private string $label;
    private string $image;
    private string $value;
    private string $badge;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getBadge(): string
    {
        return $this->badge;
    }

    public function __construct(array $data = [])
    {
        $this->populate($data);
    }
}
