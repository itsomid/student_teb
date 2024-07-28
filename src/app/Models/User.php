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
    use HasFactory, Filterable, HasApiTokens;

    const NEW_TOKEN_INTERVAL = 20;
    const MAX_TOKENS = 2;

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
        'block',
        'block_reason_description',
        'block_reason_image',
        'sms_token',
        'description',
        'sales_description',
        'sms_lock_until',
        'sms_wrong_sms_tries',
        'sms_this_token_tries',
        'profile_img',
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

    public function referrer() : BelongsTo
    {
        return $this->belongsTo(ReferralCode::class,'referral_id');
    }

    public function productAccess(): HasMany
    {
        return $this->hasMany(ProductAccess::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }

    public function getBalanceAttribute()
    {
        return $this->account ? $this->account->balance : 0;
    }

    public function getGiftAmountAttribute()
    {
        return $this->account ? $this->account->gift_amount : 0;
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
    public function created_at(): string
    {
        return Jalalian::forge($this->created_at)->format('%A, %d %B %Y');
    }
    public function isLockedToSendSms(): bool
    {
        return $this->sms_lock_until && now()->lte($this->sms_lock_until) && !app()->environment('local');
    }

    public function canGenerateToken(): bool
    {
        return empty($this->sms_token) || $this->sms_this_token_tries >= self::NEW_TOKEN_INTERVAL;
    }

    public function generateToken(): string
    {
        return
            config('app.env') === 'local'
                ? "11111"
                : str_pad(random_int(10000, 99999), 5, '0', STR_PAD_LEFT);
    }


}
