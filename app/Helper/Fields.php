<?php

namespace App\Helper;

class Fields
{
    private string $name;
    private ?string $value = "";
    private ?string $label;
    private string $type = "text";
    private bool $required = false;
    private ?array $options = [];
    private ?array $attributes = [];

    private bool $nullable = false;
    private ?string $class = null;

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function getName(): string
    {

        return $this->name;
    }

    public function getValue(): ?string
    {
        return $this->value;
    }

    public function getLabel(): ?string
    {
        if ($this->isRequired()) {
            return $this->label . " *";
        }
        return $this->label;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function getOptions(): ?array
    {
        return $this->options;
    }

    public function getAttributes(): ?array
    {
        return $this->attributes;
    }

    public function isNullable(): bool
    {
        return $this->nullable;
    }
}
