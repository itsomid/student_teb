<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSupport extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at','start_time','end_time','expired_at'];

    public $fillable = [
        'user_id',
        'user_support_id',
        'support_role',
        'start_time',
        'end_time',
        'expired_at',
        'created_at'
    ];

    public function scopeCheckExpires($query)
    {
        $query->where('expired_at', '>=', date("Y-m-d"))->orWhereNull('expired_at');
    }

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function support_user()
    {
        return $this->belongsTo(User::class,'user_support_id');
    }

    public function update_user_sales_support($delete_support=false)
    {
        if (($this->expired_at && $this->expired_at->isPast()) || ($this->end_time && $this->end_time->isPast())) {
            return false;
        }

        $user=$this->user;
        if ($delete_support) {
            $user->sales_support = null;
        }else{
            $user->sales_support = $this->user_support_id;
        }

        return $user->save();
    }
}
