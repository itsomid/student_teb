<?php

namespace App\Legacy\Listeners\Contract;

interface LegacyContract
{
    public function handle(array $data): void;
}
