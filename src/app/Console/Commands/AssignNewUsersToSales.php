<?php

namespace App\Console\Commands;

use App\Models\Admin;
use App\Models\User;
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
        $salesSupports = Admin::query()->role('sales_support')->with('allocationRate')->whereHas('allocationRate', function($q){
            $q->where('is_active', true);
        })->get();

        $students = User::query()->whereNull('sale_support_id')->get();
        $this->info('final_users count for splitting is: '.$students->count());

        $totalRate = $salesSupports->sum(function ($support) {
            return $support->allocationRate->last()->allocation_rate;
        });
        $this->info('total rate: '.$totalRate);
        $remaining_count = $students->count() % $totalRate;
        $chunk_size = ($students->count()>=$totalRate)?($students->count()-$remaining_count):0;

        $students = User::query()->whereNull('sale_support_id')->take($chunk_size)->get();

        $allocation = [];
        foreach ($salesSupports as $support) {
            $allocation[$support->id] = [
                'support' => $support,
                //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($students)),
            ];
        }

        $allocatedStudents = array_sum(array_column($allocation, 'students_count'));
        $leftoverStudents = count($students) - $allocatedStudents;

        foreach ($salesSupports as $support) {
            if ($leftoverStudents <= 0) break;
            $allocation[$support->id]['students_count'] += 1;
            $leftoverStudents--;
        }

        $studentIndex = 0;
        foreach ($allocation as $alloc) {
            $support = $alloc['support'];
            $studentsCount = $alloc['students_count'];
            $assignedStudents = $students->slice($studentIndex, $studentsCount);

            foreach ($assignedStudents as $student) {
                $student->sale_support_id = $support->id;
                $student->save();
            }

            $studentIndex += $studentsCount;
        }
    }
}
