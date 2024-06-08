<?php

namespace App\Filters\ReferralCodeFilters;

class SaleSupportId implements \App\Filters\FilterContract
{

    protected $query;

    public function __construct($query)
{
    $this->query = $query;
}

    public function handle($value= null): void
{
    if (!is_null($value))
        $this->query->where('sale_support_id', $value);
}
}
