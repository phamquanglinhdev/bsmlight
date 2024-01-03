<?php

namespace App\Helper;

class Fields
{
    private string $name;
    private mixed $value = "";
    private ?string $label;
    private string $type = "text";
    private bool $required = false;
    private ?array $options = [];
    private ?array $attributes = [];

    private string $prefix = "";
    private string $suffix = "";

    private int $nullable = 0;
    private ?string $class = null;

    public function getClass(): ?string
    {
        return $this->class;
    }

    public function getPrefix(): string
    {
        return $this->prefix;
    }

    public function getSuffix(): string
    {
        return $this->suffix;
    }

    public function __construct(array $data = [])
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                if ($value != null) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
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

    public function isNullable(): int
    {
        return $this->nullable;
    }
}
