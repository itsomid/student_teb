<?php

namespace App\Filters\UserHistorySupportFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class StudentName implements FilterContract
{

    protected Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    public function handle($value=null): void
    {
        if (!empty($value))
            $this->query->whereHas('student', fn(Builder $q) => $q->where('name', 'LIKE', "%{$value}%"));
    }
}
