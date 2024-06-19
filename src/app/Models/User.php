<?php

namespace App\Models;

use App\Brokers\RabbitMQ\RabbitMQ;
use App\Filters\Filterable;
use App\Functions\Jalali;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Morilog\Jalali\Jalalian;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    const NEW_TOKEN_INTERVAL = 30;

    use HasFactory, Filterable;

    public $filterNameSpace = 'App\Filters\StudentFilter';

    protected $fillable = [
        'id',
        'mobile',
        'name',
        'name_english',
        'city',
        'province',
        'familiarity_way',
        'field_of_study',
        'description',
        'sale_support_id',
        'gender',
        'password',
        'verified',
        'verified',
        'description',
        'sales_description',
        'created_at',
        'updated_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sms_lock_until' => 'datetime',
        'verified' => 'boolean'
    ];


    public function saleSupport(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'sale_support_id');
    }

    public function referrer()
    {
        return $this->belongsTo(ReferralCode::class,'referral_id');
    }

    public function block()
    {
        return $this->hasOne(UserBlock::class);
    }

    public function sms()
    {
        return $this->hasOne(UserSMS::class);
    }

    /**
     * @return HasMany
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function scopeCheckPermissionToGetList(Builder $query, Admin $admin)
    {
        // If User Has This Permission, So He/She Can See List Of All Users
        return $admin->can('student.manage-all-user')
            ? $query
            : User::where('sale_support_id', $admin->id);


    }

    public function scopeCheckPermissionToGetRefferalUser(Builder $query, Admin $admin,ReferralCode $referral_code=null)
    {
        if ($admin->can('student.manage-all-user')){
            return $query;
        }

        if($referral_code){
            return User::where('referral_id', $referral_code->id);
        }else{
            return User::whereRaw('1 = 0');
        }
//        return $admin->can('student.manage-all-user')
//            ? $query
//            : User::where('referral_id', $referral_code);
    }

    public function created_at()
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function isLocked()
    {
        return $this->sms_lock_until && now()->lte($this->sms_lock_until) && !app()->environment('local');
    }

    public function canGenerateToken()
    {
        return empty($this->sms_token) || $this->sms_this_token_tries >= self::NEW_TOKEN_INTERVAL;
    }

    public function generateToken()
    {
        return
            config('app.env') === 'local'
                ? 11111
                : mt_rand(10000, 99999);
    }

}
