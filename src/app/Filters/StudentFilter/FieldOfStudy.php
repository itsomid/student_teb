<?php

namespace App\Filters\StudentFilter;

use App\Filters\FilterContract;

class FieldOfStudy implements FilterContract
{

    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value= null): void
    {

        if (!is_null($value))
            $this->query->where('field_of_study', $value);
    }
}
