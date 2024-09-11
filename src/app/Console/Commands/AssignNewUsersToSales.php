<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
use App\Services\DistributeStudents;
use Illuminate\Console\Command;

class AssignNewUsersToSales extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:assign-new-users-to-sales';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The command assigns students to sales support teams based on the allocation rates of available supports.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $object= new DistributeStudents();
        $object->description('distributed automatically')
            ->do();
    }
}
