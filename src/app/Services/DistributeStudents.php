<?php

namespace App\Services;

use App\Data\Grades;
use App\Models\Admin;
use App\Models\CommissionType;
use App\Models\SupportMap;
use App\Models\User;

class DistributeStudents
{
    private ?int $support_id= null;
    private array $distributeAmong=[];
    private $description;

    public function owner(int|null $support_id= null)
    {
        $this->support_id = $support_id;
        return $this;
    }

    public function among(array $support_ids)
    {
        $this->distributeAmong = $support_ids;
        return $this;
    }

    public function description($description)
    {
        $this->description = $description;
        return $this;
    }


    public function do()
    {
        $this->distribute();
    }

    protected function distribute()
    {
        $support_map= SupportMap::query()->with('admins.allocationRate')->get();

        foreach ($support_map as $map) {
            //Get Relevant Students
            $students = User::query()
                ->where('sale_support_id', $this->support_id)
                ->whereIn('grade', $map->grades)
                ->get();


            $admins = $map->admins->filter(function ($admin , $index) {
                return $admin->id != $this->support_id;
            });

            if(count($this->distributeAmong)){
                $admins = $admins->filter(function ($admin , $index) {
                    return in_array($admin->id, $this->distributeAmong);
                });
            }

            //Calculate Total Rate
            $totalRate = $admins->sum(function ($support) {
                return $support->allocationRate->last()->allocation_rate;
            });

            //Fail fast if there are no students or supports, It may result in divide by zero error

            if(count($students) == 0 || count($admins) == 0)
            {
                continue;
            }

            $remaining_count = $students->count() % $totalRate;
            $chunk_size = ($students->count()>=$totalRate)?($students->count()-$remaining_count):0;

            $students = User::query()
                ->where('sale_support_id', $this->support_id)
                ->whereIn('grade', $map->grades)
                ->take($chunk_size)
                ->get();;

            $allocation = [];
            foreach ($admins as $support) {
                $allocation[$support->id] = [
                    'support' => $support->id,
                    //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                    'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($students)),
                ];
            }


            $studentIndex = 0;
            foreach ($allocation as $alloc) {
                $support = $alloc['support'];
                $studentsCount = $alloc['students_count'];
                $assignedStudents = $students->slice($studentIndex, $studentsCount);

                foreach ($assignedStudents as $student) {
                    $student->updateSupport( $support->id, $this->description);
                }

                $studentIndex += $studentsCount;
            }


            $this->makeRemainedStudentsAssignable();
        }
    }



    protected function makeRemainedStudentsAssignable(): void
    {
        if(is_null($this->support_id))
        {
            return;
        }

        $remained_students= User::query()
            ->where('sale_support_id', $this->support_id)
            ->get();

        foreach ($remained_students as $student) {
            $student->updateSupport( null, 'made null to assign later (remained student)');
        }
    }
}
