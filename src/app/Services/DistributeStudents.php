<?php

namespace App\Services;

use App\Data\Grades;
use App\Models\Admin;
use App\Models\CommissionType;
use App\Models\User;

class DistributeStudents
{
    private ?int $support_id;
    private array $distributeAmong;
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
        $this->distributeElementaryStudents();
        $this->distributeNoneElementaryStudents();
        $this->makeRemainStudentsAssignable();
    }


    protected function distributeElementaryStudents()
    {
        $ElementarySalesSupports = $this->getElementarySalesSupport();
        $ElementaryStudents = $this->getElementaryStudents();

        $totalRate = $ElementarySalesSupports->sum(function ($support) {
            return $support->allocationRate->last()->allocation_rate;
        });

        if(count($ElementarySalesSupports) == 0 || count($ElementaryStudents) == 0){
            return;
        }

        $remaining_count = $ElementaryStudents->count() % $totalRate;
        $chunk_size = ($ElementaryStudents->count()>=$totalRate)?($ElementaryStudents->count()-$remaining_count):0;

        $ElementaryStudents = $this->getElementaryStudents($chunk_size);

        $allocation = [];
        foreach ($ElementarySalesSupports as $support) {
            $allocation[$support->id] = [
                'support' => $support,
                //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($ElementaryStudents)),
            ];
        }


        $studentIndex = 0;
        foreach ($allocation as $alloc) {
            $support = $alloc['support'];
            $ElementaryStudentsCount = $alloc['students_count'];
            $assignedStudents = $ElementaryStudents->slice($studentIndex, $ElementaryStudentsCount);

            foreach ($assignedStudents as $student) {
                $student->updateSupport( $support->id, $this->description);
            }

            $studentIndex += $ElementaryStudentsCount;
        }
    }

    protected function distributeNoneElementaryStudents(){
        $noneElementarySalesSupports = $this->getNonElementarySalesSupport();
        $noneElementaryStudents = $this->getNoneElementaryStudents();

        $totalRate = $noneElementarySalesSupports->sum(function ($support) {
            return $support->allocationRate->last()->allocation_rate;
        });

        if(count($noneElementaryStudents) == 0 || count($noneElementarySalesSupports) == 0){
            return;
        }

        $remaining_count = $noneElementaryStudents->count() % $totalRate;
        $chunk_size = ($noneElementaryStudents->count()>=$totalRate)?($noneElementaryStudents->count()-$remaining_count):0;

        $noneElementaryStudents = $this->getNoneElementaryStudents($chunk_size);

        $allocation = [];
        foreach ($noneElementarySalesSupports as $support) {
            $allocation[$support->id] = [
                'support' => $support,
                //فرمول اصلی که به پشتیبان چند دانش آموز داده شود
                'students_count' => intval($support->allocationRate->last()->allocation_rate / $totalRate * count($noneElementaryStudents)),
            ];
        }

        $studentIndex = 0;
        foreach ($allocation as $alloc) {
            $support = $alloc['support'];
            $noneElementaryStudentsCount = $alloc['students_count'];
            $assignedStudents = $noneElementaryStudents->slice($studentIndex, $noneElementaryStudentsCount);

            foreach ($assignedStudents as $student) {
                $student->updateSupport( $support->id, $this->description);
            }

            $studentIndex += $noneElementaryStudentsCount;
        }
    }


    protected function getElementarySalesSupport()
    {
        return Admin::query()->role('sales_support')
            ->whereIn('id', CommissionType::getElementarySupports()->pluck('support_id')->toArray())
            ->with('allocationRate')
            ->when(!is_null($this->support_id), function ($query) {
                $query->where('id', '<>', $this->support_id);
            })
            ->when(count($this->distributeAmong) > 0, function ($query) {
                $query->whereIn('id', $this->distributeAmong);
            })
            ->whereHas('allocationRate', function($q){
                $q->where('is_active', true);
            })->get();
    }



    protected function getNonElementarySalesSupport()
    {
        return Admin::query()->role('sales_support')
            ->whereNotIn('id', CommissionType::getElementarySupports()->pluck('support_id')->toArray())
            ->with('allocationRate')
            ->when(!is_null($this->support_id), function ($query) {
                $query->where('id', '<>', $this->support_id);
            })
            ->when(count($this->distributeAmong) > 0, function ($query) {
                $query->whereIn('id', $this->distributeAmong);
            })
            ->whereHas('allocationRate', function($q){
                $q->where('is_active', true);
            })->get();
    }




    protected function getElementaryStudents($chunk_size=null)
    {
        return User::query()
            ->where('sale_support_id', $this->support_id)
            ->when(!is_null($chunk_size),function($q) use ($chunk_size){
                return $q->take($chunk_size);
            })
            ->whereIn('grade', array_keys(Grades::getElementaryGrades()))
            ->get();
    }



    protected function getNoneElementaryStudents($chunk_size=null)
    {
        return User::query()
            ->where('sale_support_id', $this->support_id)
            ->when(!is_null($chunk_size),function($q) use ($chunk_size){
                return $q->take($chunk_size);
            })
            ->whereNotIn('grade', array_keys(Grades::getElementaryGrades()))
            ->get();
    }

    protected function makeRemainStudentsAssignable()
    {
        if(!is_null($this->support_id))
            return User::query()
                ->where('sale_support_id', $this->support_id)
                ->update(['sale_support_id' => null]);
    }
}
