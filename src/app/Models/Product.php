<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use App\Filters\Filterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;


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

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
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

    public function cartItem()
    {
        return $this->hasMany(CartItem::class);
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

    public static function getProductsTree()
    {
        //new Algorithm - By M.Majidfar
        $all_products = static::orderBy('parent_id', 'asc')->get();
        $init_array = []; //all products_ids with their parent_id
        $result = []; //final result

        foreach ($all_products as $tmp_product) {
            $init_array[$tmp_product->id] = $tmp_product->parent_id;
        }

        foreach ($all_products as $tmp_product) {
            if (!$tmp_product->parent_id) {
                $result[$tmp_product->id] = [];
            } else {
                //running BFF algorithm for searching parent_id in $result
                $result = static::ProductsTreeBFFsearch($result, ['id' => $tmp_product->id, 'parent_id' => $tmp_product->parent_id]);
            }
        }

        return $result;


    }

    public static function ProductsTreeBFFsearch($stack, $needle)
    {
        $my_product_id = $needle['id'];
        $my_product_parent_id = $needle['parent_id'];

        foreach ($stack as $index_parent_id => $children_ids) {
            if ($index_parent_id == $my_product_parent_id) {
                $stack[$index_parent_id][$my_product_id] = [];
                return $stack;
            }
        }

        foreach ($stack as $index_parent_id => $children_ids) {
            if (count($children_ids) > 0) {
                $stack[$index_parent_id] = static::ProductsTreeBFFsearch($children_ids, $needle);
            }
        }

        return $stack;
    }

    public static function getProductsTreeLeafs($users_products_ids, $input_array, $return_all = false)
    {
        $result = [];
        if ($input_array && count($input_array) > 0) {
            foreach ($input_array as $key => $value) {
                if ($return_all || in_array($key, $users_products_ids)) {

                    $result[] = $key;
                    $result = array_merge($result, static::getProductsTreeLeafs($users_products_ids, $value, true));
                } else {
                    $result = array_merge($result, static::getProductsTreeLeafs($users_products_ids, $value, false));
                }
            }
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

    public function getPrice()
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

    static public function formatPrice($price)
    {
        return number_format($price, 0) . " ریال";
    }
}
