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
    private array $filters;

    /**
     * @return Filter[]
     */
    public function getFilters(): array
    {
        return $this->filters;
    }

    public function addFilter(array $data = []): void
    {
        $this->filters[] = new Filter($data);
    }
    private ?int $id = null;

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

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
