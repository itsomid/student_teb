<?php

namespace App\Filters\StudentFilter;

class SearchKey implements \App\Filters\FilterContract
{

    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    public function handle($value= null): void
    {
        if (!is_null($value) )
            $this->query->where('id', $value)->orWhere('mobile', 'LIKE' , '%'.$value.'%')->orWhere('name', 'LIKE', '%'.$value.'%');


    }
}
