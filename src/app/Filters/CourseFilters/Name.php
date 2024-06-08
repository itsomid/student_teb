<?php

namespace App\Filters\CourseFilters;

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
            $this->query->whereHas('product', function ($query) use ($value) {
                $query->where('name', 'LIKE', "%$value%");
            });
    }
}
