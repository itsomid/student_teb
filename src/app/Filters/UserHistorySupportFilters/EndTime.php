<?php

namespace App\Filters\UserHistorySupportFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class EndTime implements FilterContract
{

    protected Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }
    public function handle($value=null): void
    {
        if (!empty($value))
            $this->query->where('end_time', '<=', $value);
    }
}
