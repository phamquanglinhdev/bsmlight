<?php

namespace App\Helper;

trait BaseObject
{
    private function populate(array $data = []): void
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key) && $value !== null) {
                $this->{$key} = $value;
            }
        }
    }
}
