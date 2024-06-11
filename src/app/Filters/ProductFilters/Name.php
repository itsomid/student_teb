<?php

namespace App\Filters\ProductFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class Name implements FilterContract
{
    protected Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value= null): void
    {
        if (!is_null($value))
            $this->query->where('name', 'LIKE', "%$value%");
    }
}
