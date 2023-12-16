<?php

namespace App\Helper;

class Filter
{
    use BaseObject;

    private string $name;
    private string $label;

    public function getLabel(): string
    {
        return $this->label;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
    private string $type = 'text';
    private array $attributes = [];
    private mixed $value = null;

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function __construct(array $data = [])
    {
        $this->populate($data);
    }
}
