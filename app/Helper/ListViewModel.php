<?php

namespace App\Helper;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

class ListViewModel
{
    public function __construct(
        private readonly LengthAwarePaginator $collection
    )
    {

    }

    public function getOriginCollection(): LengthAwarePaginator
    {
        return $this->collection;
    }

    /**
     * @return array
     */
    public function getCollectionItem(): array
    {
        return $this->collection->map(fn(Model $model) => $model->attributesToArray())->toArray();
    }
}
