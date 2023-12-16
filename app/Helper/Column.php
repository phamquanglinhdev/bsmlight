<?php

namespace App\Helper;

class Column
{
    use BaseObject;

    private string $name;
    private string $value;
    private string $class;
    private string $id;
    private string $type = "text";
    private string $label;
    private array $attributes = [];

    public function getLabel(): string
    {
        return $this->label;
    }

    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}
