<?php

namespace App\Services;

use App\Data\Grades;
use App\Models\Admin;
use App\Models\CommissionType;
use App\Models\User;

class DistributeStudents
{
    private ?int $support_id;

    public function distribute(int|null $support_id= null)
    {
        $this->support_id = $support_id;

    }

    protected function distributeElementaryStudents()
    {
        $ElementarySalesSupports = $this->getElementarySalesSupport();
        $ElementaryStudents = $this->getElementaryStudents();

        $totalRate = $ElementarySalesSupports->sum(function ($support) {
            return $support->allocationRate->last()->allocation_rate;
        });


        $remaining_count = $ElementaryStudents->count() % $totalRate;
        $chunk_size = ($ElementaryStudents->count()>=$totalRate)?($ElementaryStudents->count()-$remaining_count):0;

        $ElementaryStudents = $ElementaryStudents->take($chunk_size)->get();

        $allocation = [];
        foreach ($ElementarySalesSupports as $support) {
            $allocation[$support->id] = [
                'support' => $support,
                //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($ElementaryStudents)),
            ];
        }

        $allocatedStudents = array_sum(array_column($allocation, 'students_count'));
        $leftoverStudents = count($ElementaryStudents) - $allocatedStudents;

        foreach ($ElementarySalesSupports as $support) {
            if ($leftoverStudents <= 0) break;
            $allocation[$support->id]['students_count'] += 1;
            $leftoverStudents--;
        }

        $studentIndex = 0;
        foreach ($allocation as $alloc) {
            $support = $alloc['support'];
            $ElementaryStudentsCount = $alloc['students_count'];
            $assignedStudents = $ElementaryStudents->slice($studentIndex, $ElementaryStudentsCount);

            foreach ($assignedStudents as $student) {
                $student->sale_support_id = $support->id;
                $student->save();
            }

            $studentIndex += $ElementaryStudentsCount;
        }
    }


    protected function distributeNoneElementaryStudents(){
        $noneElementarySalesSupports = $this->getNonElementarySalesSupport();
        $noneElementaryStudents = $this->getNonElementarySalesSupport();

        $totalRate = $noneElementarySalesSupports->sum(function ($support) {
            return $support->allocationRate->last()->allocation_rate;
        });


        $remaining_count = $noneElementaryStudents->count() % $totalRate;
        $chunk_size = ($noneElementaryStudents->count()>=$totalRate)?($noneElementaryStudents->count()-$remaining_count):0;

        $noneElementaryStudents = $noneElementaryStudents->take($chunk_size)->get();

        $allocation = [];
        foreach ($noneElementarySalesSupports as $support) {
            $allocation[$support->id] = [
                'support' => $support,
                //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($noneElementaryStudents)),
            ];
        }

        $allocatedStudents = array_sum(array_column($allocation, 'students_count'));
        $leftoverStudents = count($noneElementaryStudents) - $allocatedStudents;

        foreach ($noneElementarySalesSupports as $support) {
            if ($leftoverStudents <= 0) break;
            $allocation[$support->id]['students_count'] += 1;
            $leftoverStudents--;
        }

        $studentIndex = 0;
        foreach ($allocation as $alloc) {
            $support = $alloc['support'];
            $noneElementaryStudentsCount = $alloc['students_count'];
            $assignedStudents = $noneElementaryStudents->slice($studentIndex, $noneElementaryStudentsCount);

            foreach ($assignedStudents as $student) {
                $student->sale_support_id = $support->id;
                $student->save();
            }

            $studentIndex += $noneElementaryStudentsCount;
        }
    }




    protected function getElementarySalesSupport()
    {
        return Admin::query()->role('sales_support')
            ->whereIn('id', CommissionType::getElementarySupports()->pluck('support_id')->toArray())
            ->with('allocationRate')
            ->whereHas('allocationRate', function($q){
                $q->where('is_active', true);
            })->get();
    }

    protected function getNonElementarySalesSupport()
    {
        return Admin::query()->role('sales_support')
            ->whereNotIn('id', CommissionType::getElementarySupports()->pluck('support_id')->toArray())
            ->with('allocationRate')
            ->whereHas('allocationRate', function($q){
                $q->where('is_active', true);
            })->get();
    }


    protected function getElementaryStudents($support_id)
    {
        return User::query()
            ->where('sale_support_id', $this->support_id)
            ->whereIn('grade', array_keys(Grades::getElementaryGrades()))
            ->get();
    }

    protected function getNoneElementaryStudents($support_id)
    {
        return User::query()
            ->where('sale_support_id', $support_id)
            ->whereNotIn('grade', array_keys(Grades::getElementaryGrades()))
            ->get();
    }
}
