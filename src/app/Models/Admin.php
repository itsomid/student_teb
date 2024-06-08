<?php

namespace App\Models;

use App\Filters\Filterable;
use App\Functions\Jalali;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @method static adminAndSupervisor()
 */
class Admin extends Authenticatable
{
    const ROOT_ID = 1;
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable, HasRoles, Jalali, Filterable;

    public $filterNameSpace = 'App\Filters\AdminFilters';

    protected $fillable = ['mobile', 'email', 'first_name', 'last_name', 'password','gender', 'supervisor_id', 'teacher_id', 'instagram', 'telegram', 'whatsapp'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];


    //-----------------------------------------------------------------------------------------------------//
    //---------------------------------------------    #Boot  ---------------------------------------------//

    public static function boot()
    {
        parent::boot();
//        static::created(function (User $user) {
//            RabbitMQ::onExchange('staff')->setRoutingKey('staff.staff')->withTopicType()->setData($user->toArray())->dispatch();
//        });
    }

    //-----------------------------------------------------------------------------------------------------//
    //------------------------------------------    #Relations   ------------------------------------------//
    public function students(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(Session::class,'user_id');
    }

    public function referralCodes(): HasMany
    {
        return $this->hasMany(ReferralCode::class,'admin_id');
    }

    public function team(): HasMany
    {
        return $this->hasMany(Admin::class, 'supervisor_id');
    }

    public function supervisor(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'supervisor_id');
    }

    public function allocationRate(): HasMany
    {
        return $this->hasMany(SupportsAllocationRate::class, 'sale_support_id');
    }



    //-----------------------------------------------------------------------------------------------------//
    //------------------------------------------    #Scopes      ------------------------------------------//

    //E.g  => User::search('0910')->get();
    public function scopeSearch($query, $key)
    {
        return (is_null($key)) ? $query
            : $query->where("id", "=", $key)->
            orWhere("mobile", "LIKE", "%$key%")->
            orWhere("first_name", "LIKE", "%$key%")->
            orWhere("last_name", "LIKE", "%$key%")->
            orWhere("email", "LIKE", "%$key%");
    }

    //E.g  => User::query()->supervisor()->get();
    public function scopeAdminAndSupervisor(Builder $query)
    {
        return $query->role(['admin', 'sales_supervisor']);
    }


    public static function scopeSalesSupportAndSupervisor(Builder $query)
    {
        return $query->role(['sales_support', 'sales_supervisor']);
    }

    public static function scopeCheckPermissionToGetSalesSupportList(Builder $query, Admin $admin)
    {
        return $admin->can('admin.manage-all-sales-support')
            ? $query->role(['sales_support', 'sales_supervisor'])
            : $query->where('id', $admin->id);
    }
    //-----------------------------------------------------------------------------------------------------//
    //------------------------------------------   #Attributes   ------------------------------------------//
    public function fullname()
    {
        return $this->first_name . " " . $this->last_name;
    }

    public function avatar()
    {
        $random = rand(1, 9);
        return is_null($this->avatar)
            ? asset("images/avatars/{$this->gender}/{$random}.png")
            : $this->avatar;
    }

    public function status($class = false)
    {
        return $class
            ? ($this->is_active ? 'success' : 'danger')
            : ($this->is_active ? 'فعال' : 'غیر فعال');
    }
}
