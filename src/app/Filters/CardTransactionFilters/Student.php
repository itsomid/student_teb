<?php

namespace App\Filters\CardTransactionFilters;

use App\Filters\FilterContract;
use Illuminate\Database\Eloquent\Builder;

class Student implements FilterContract
{
    protected Builder $query;
    public function handle($value): void
    {
        if(is_numeric($value)){
            $this->query->where('student_id', $value);
        }
    }
}
