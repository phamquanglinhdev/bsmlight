<?php

namespace App\Helper\Object;

use App\Helper\BaseObject;

class CustomFieldShow
{
    use BaseObject;
    private string $label;
    private string $value;

    public function __construct(array $data = [])
    {
        $this->populate($data);
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
