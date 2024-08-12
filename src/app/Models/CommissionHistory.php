<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Morilog\Jalali\Jalalian;

class CommissionHistory extends Model
{
    protected $fillable= ['changed_by', 'type_id', 'percentage', 'description', 'theme', 'all_data'];

    public function commission()     {return $this->belongsTo(Commission::class,      'commission_id');}
    public function type()           {return $this->belongsTo(CommissionType::class, 'type_id')->withTrashed();}
    public function changer()        {return $this->belongsTo(Admin::class,            'changed_by');}


    public function created_at()    {return Jalalian::forge($this->created_at)->toDateTimeString();}
    public static function getPeriods($start_at, $end_at, $support_id)
    {
        $commission= Commission::query()->where('support_id', $support_id)->first();
        $histories= CommissionHistory::query()->where('commission_id', $commission->id)->oldest()->get();

        $collection= collect();
        foreach ($histories as $key => $history)
        {
            $period= new \stdClass();

            $period->from= $key == 0 ? $start_at : $history->created_at;
            $period->to=   $key == $histories->count()-1 ? $end_at : $histories[$key+1]->created_at;

            $period->percentage= $history->percentage;
            $period->type_name=  $history->type->title;

            $collection->push($period);
        }

        return $collection;
    }
}
