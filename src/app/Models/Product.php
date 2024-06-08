<?php

namespace App\Models;

use App\Enums\ProductTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Product extends Model
{
    use HasFactory, SoftDeletes;

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
        'sort_num'
    ];

    protected function casts(): array
    {
        return [
            'options' => 'json',
            'product_type_id' => ProductTypeEnum::class
        ];
    }
    public static function get_free_products_ids()
    {
        $products = static::where('original_price',0)->orWhere('off_price',0)->get();
        $result=[];
        foreach ($products as $product) {
            $result[$product->id]=$product->id;
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

    public function isActiveCourse()
    {
        return is_null($this->parent_id) && ! $this->archived && $this->show_in_list && $this->is_purchasable;
    }
    public function scopeActiveCourses($query)
    {
        return $query->whereNull('parent_id')->where('archived',0)->where('show_in_list',1)->where('is_purchasable',1);
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
        return $this->hasOne(Course::class,'product_id');
    }

    public function class(): HasOne
    {
        return $this->hasOne(Classes::class,'product_id');
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class);
    }
}
