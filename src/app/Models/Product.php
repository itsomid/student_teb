<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use App\Filters\Filterable;
use App\Services\ProductService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Morilog\Jalali\Jalalian;


class Product extends Model
{
    use HasFactory, SoftDeletes, Filterable;

    public $filterNameSpace = 'App\Filters\ProductFilters';
    public $fillable = [
        'parent_id',
        'name',
        'original_price',
        'off_price',
        'description',
        'options',
        'user_id',
        'product_type_id',
        'img_filename',
        'is_purchasable',
        'has_installment',
        'installment_count',
        'first_installment_ratio',
        'final_installment_date',
        'show_in_list',
        'archived',
        'expiration_duration',
        'sort_num',
        'subscription_start_at'
    ];

    protected function casts(): array
    {
        return [
            'options' => 'json',
            'product_type_id' => ProductTypeEnum::class
        ];
    }

    protected static function boot(): void
    {
        parent::boot();

        self::created(function(self $model){
            ProductService::clearProductTreeCache();
        });

        self::updated(function(self $model){
            ProductService::clearProductTreeCache();
        });

        self::deleted(function(self $model){
            ProductService::clearProductTreeCache();
        });
    }

    public function isActiveCourse()
    {
        return is_null($this->parent_id) && !$this->archived && $this->show_in_list && $this->is_purchasable;
    }

    public function scopeActiveCourses($query)
    {
        return $query->whereNull('parent_id')->where('archived', 0)->where('show_in_list', 1)->where('is_purchasable', 1);
    }

    public function scopeRemoveArchived($query)
    {
        return $query->where('archived', 0);
    }

    /**
     * @return HasOne
     */
    public function course(): HasOne
    {
        return $this->hasOne(Course::class, 'product_id');
    }

    public function class(): HasOne
    {
        return $this->hasOne(Classes::class, 'product_id');
    }

    /**
     * @return HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return HasMany
     */
    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * @return HasManyThrough
     */
    public function cash_amounts(): HasManyThrough
    {
        return $this->hasManyThrough(CashAmount::class, OrderItem::class);
    }

    /**
     * @return HasOne
     */
    public function teacher_commission(): HasOne
    {
        return $this->hasOne(TeacherProductCommission::class)
            ->join('products', 'teacher_product_commissions.product_id', '=', 'products.id') // Join products table
            ->select('teacher_product_commissions.*')
            ->whereColumn('teacher_id', 'products.user_id');
    }

    /**
     * Teacher Paid Lists
     * @return HasMany
     */
    public function teacher_payments(): HasMany
    {
        return $this->hasMany(TeacherPayments::class, 'product_id', 'id');
    }
    public function scopeCategoriesWithType(Builder $query, $type)
    {
        return $query->categories->where('type', $type);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    /**
     * @return HasMany
     */
    public function packages(): HasMany
    {
        return $this->hasMany(CustomPackage::class);
    }

    public function cartItem(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * @return HasMany
     */
    public function teacherCommission(): HasMany
    {
        return $this->hasMany(TeacherProductCommission::class);
    }

    public static function get_free_products_ids()
    {
        $products = static::where('original_price', 0)->orWhere('off_price', 0)->get();
        $result = [];
        foreach ($products as $product) {
            $result[$product->id] = $product->id;
        }
        return $result;
    }

    public function getInstallmentPrice(): int
    {
        $result = ($this->price * 1.05);

        return (int) ceil($result);
    }
    public function getImageSrc()
    {
        if ($this->img_filename) {
            return $this->img_filename;
        } else {
            return "default_product_img.jpg";
        }
    }

    /**
     * @return string
     */
    public function getImageUrl(): string
    {
        if ($this->img_filename)
            return asset('storage/products/' . $this->img_filename);
        else
            return asset('images/default_product_img.jpg');
    }

    public function getPriceAttribute()
    {
        $final_price = $this->attributes['original_price'];

        //if this is first class of a course
        /*if($this->product_type_id==2 && $this->product_live_course_class && $this->product_live_course_class->first_attend_free && !Auth::user()->has_purchased_any_of_this_product_package($this->parent->id)){
            return 0;
        }*/

        //check off price
        if ($this->attributes['off_price']) {
            $final_price = $this->attributes['off_price'];
        }

        //check coupon
        if ($this->coupon) {
            return $this->coupon->calculatePrice($this->attributes['original_price']);
        }

        return $final_price;
    }

    public function getPrice(): string
    {
        if ($this->is_purchasable) {

            if ($this->original_price > 0) {
                return Product::formatPrice($this->original_price);
            } else {
                return "رایگان";
            }
        } else {
            return "قابل خرید مجزا نمی باشد";
        }
    }

    static public function formatPrice(int $price): string
    {
        return number_format($price, 0) . " ریال";
    }

    /**
     * Get the final installment date in Jalali format
     *
     * @return string|null
     */
    public function final_installment_date(): ?string
    {
        if (!$this->final_installment_date) {
            return null;
        }
        return Jalalian::forge($this->final_installment_date)->format('%Y/%m/%d H:i:s');
    }
}
