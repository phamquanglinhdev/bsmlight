<?php

namespace App\Helper;

/**
 *
 */
class CrudBag
{
    /**
     * @var array
     */
    public array $fields;
    private string $label;
    private string $entity;
    private array $columns;

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): void
    {
        $this->label = $label;
    }

    public function getEntity(): string
    {
        return $this->entity;
    }

    public function setEntity(string $entity): void
    {
        $this->entity = $entity;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    private string $action;

    /**
     * @param $data
     * @return void
     */
    public function addFields($data): void
    {
        $this->fields[] = new Fields($data);
    }

    /**
     * @return Fields[]
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    public function addColumn(array $data = []): void
    {
        $this->columns[] = new Column($data);
    }

    /**
     * @return Column[]
     */
    public function getColumns(): array
    {
        return $this->columns;
    }
}
