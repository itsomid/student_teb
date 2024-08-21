<?php

namespace App\Filters\InstallmentFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class UserId implements FilterContract
{
    protected Builder $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value= null): void
    {
        if (!is_null($value))
            $this->query->whereIn('user_id', $value);
    }
}
