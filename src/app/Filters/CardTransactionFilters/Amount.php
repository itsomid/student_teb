<?php

namespace App\Filters\CardTransactionFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class Amount implements FilterContract
{
    protected Builder $query;
    public function handle($value): void
    {
        if(!is_null($value)){
            $this->query->where('amount', $value);
        }
    }
}
