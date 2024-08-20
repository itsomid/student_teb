<?php

namespace App\Legacy\Commands;

use App\Brokers\RabbitMQ\RabbitMQ;
use Illuminate\Console\Command;

class ConsumeFromLegacy extends Command
{
    protected $signature = 'app:consume-from-legacy';
    protected $description = 'Command description';

    public function handle()
    {
        RabbitMQ::consume()->queue('nexus')->listen();
    }
}
