<?php

namespace App\Models;

use App\Helpers\PanelConditions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Morilog\Jalali\Jalalian;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;


    const  RANGE_KEY = [
        'start'     =>  'coupons_start_discount_range',
        'end'       =>  'coupons_end_discount_range',
        'ids'       =>  'coupons_conditions_products_ids'
    ];
    protected array $dates = [
        'expired_at',
        'deleted_at'
    ];


    public $fillable = [
        'creator_user_id',
        'coupon',
        'consumer_user_id',
        'specific_product_id',
        'discount_percentage',
        'discount_amount',
        'conditions',
        'is_disposable',
        'is_multiuser',
        'has_purchased',
        'expired_at',
        'description',
        'for_old_users',
        'for_old_users_min_pay',
        'is_mass'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'creator_user_id' => 'integer',
        'consumer_user_id' => 'integer',
        'specific_product_id' => 'integer',
        'discount_percentage' => 'float',
        'discount_amount' => 'integer',
        'conditions' => 'json'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static array $rules = [

    ];

    public function scopeOwns($query, $userId)
    {
        return $query->where('creator_user_id', $userId);
    }

    public function canDoAction($userId): bool
    {
        return $this->creator_user_id === $userId;
    }

    public function getConditionAttribute()
    {
        return json_decode($this->attributes['conditions']);
    }

    public function creator_user(): BelongsTo
    {
        return $this->belongsTo(Admin::class,'creator_user_id');
    }

    public function consumer_user(): BelongsTo
    {
        return $this->belongsTo(User::class,'consumer_user_id');
    }

    public function specific_product(): BelongsTo
    {
        return $this->belongsTo(Product::class,'specific_product_id');
    }

    public function expired_at()
    {
        return Jalalian::forge($this->created_at)->toDateTimeString();
    }
    public function calculatePrice($price): int
    {
        $result = $price;

        if ($this->discount_percentage) {
            $result = ((100-$this->discount_percentage)/100)*$result;
        }elseif ($this->discount_amount) {
            $result -= $this->discount_amount;
            $result = ($result<0)?0:$result;
        }

        return $result;
    }

    static public function isCouponValid($couponId, $user, $product): bool
    {
        $coupon = Coupon::where('id',$couponId)->first();

        //check if coupon exists
        if (!$coupon) {
            return false;
        }

        //check if belongs to this user
        if ($coupon->consumer_user_id) {
            if ($coupon->consumer_user_id != $user->id) {
                return false;
            }
        }

        //check if belongs to specific product
        if ($coupon->specific_product_id) {
            if ($coupon->specific_product_id != $product->id) {
                return false;
            }
        }

        //check expiration
        if ($coupon->expired_at) {
            if ($coupon->expired_at->isPast()) {

                return false;
            }
        }

        //check if user used this coupon before
        if ($coupon->is_disposable) {
            $last_transaction_coupon = TransactionLogs::where('user_id',$user->id)->where('coupon_id',$coupon->id)->first();
            if ($last_transaction_coupon) {

                return false;
            }
        }

        //check if other users use this
        if (!$coupon->is_multiuser) {
            $last_transaction_coupon = TransactionLogs::where('user_id','!=',$user->id)->where('coupon_id',$coupon->id)->first();
            if ($last_transaction_coupon) {

                return false;
            }
        }

        // Check is just for old-users
        if ($coupon->for_old_users) {
            if (!OldUsers::where('user_mobile', $user->mobile)
                ->where('paid', '>=', $coupon->for_old_users_min_pay)
                ->first(['id'])
            ) {
                return false;
            }
        }

        //check conditions
        if ($coupon->conditions) {
            if (!PanelConditions::checkPermissions($coupon->condition,$user,1,$product)) {
                return false;
            }
        }

        //check user has purchased
        if ($coupon->has_purchased != 2){
            if ($coupon->has_purchased == 0){
                if ($user->total_buy_amount() > 0){
                    return false;
                }
            }
            elseif ($coupon->has_purchased == 1){
                if ($user->total_buy_amount() <= 0){
                    return false;
                }
            }
        }

        $product->coupon = $coupon;
        return $coupon;
    }


    static public function checkCoupon($coupon_text, $user, $product)
    {
        $coupon = Coupons::where('coupon',strtolower($coupon_text))->first();

        //check if coupon exists
        if (!$coupon) {
            return false;
        }

        //check if belongs to this user
        if ($coupon->consumer_user_id) {
            if ($coupon->consumer_user_id != $user->id) {
                return false;
            }
        }

        //check if belongs to specific product
        if ($coupon->specific_product_id) {
            if ($coupon->specific_product_id != $product->id) {
                return false;
            }
        }

        //check expiration
        if ($coupon->expired_at) {
            if ($coupon->expired_at->isPast()) {
                return false;
            }
        }

        //check if user used this coupon before
        if ($coupon->is_disposable) {
            $last_transaction_coupon = TransactionLogs::where('user_id',$user->id)->where('coupon_id',$coupon->id)->first();
            if ($last_transaction_coupon) {
                return false;
            }
        }

        //check if other users use this
        if (!$coupon->is_multiuser) {
            $last_transaction_coupon = TransactionLogs::where('user_id','!=',$user->id)->where('coupon_id',$coupon->id)->first();
            if ($last_transaction_coupon) {
                return false;
            }
        }

        // Check is just for old-users
        if ($coupon->for_old_users) {
            if (!OldUsers::where('user_mobile', $user->mobile)
                ->where('paid', '>=', $coupon->for_old_users_min_pay)
                ->first(['id'])
            ) {
                return false;
            }
        }

        //check conditions
        if ($coupon->conditions) {
            if (!PanelConditions::checkPermissions($coupon->condition,$user,1,$product)) {
                return false;
            }
        }

        //check user has purchased
        if ($coupon->has_purchased != 2){
            if ($coupon->has_purchased == 0){
                if ($user->total_buy_amount() > 0){
                    return false;
                }
            }
            elseif ($coupon->has_purchased == 1){
                if ($user->total_buy_amount() <= 0){
                    return false;
                }
            }
        }

        $product->coupon = $coupon;
        return $coupon;
    }
    public function transaction_logs(): HasMany
    {
        return $this->hasMany('App\Models\TransactionLogs','coupon_id');
    }

    public function coupons_sum_amount(): int
    {
        return $this->transaction_logs()->sum('amount');
    }

    public function coupons_used_count(): int
    {
        return $this->transaction_logs()->count();
    }

    public function number_of_use_increament(): void
    {
        $this->number_of_use = $this->number_of_use + 1 ;
        $this->save();
    }

}
