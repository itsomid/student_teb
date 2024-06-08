<?php

namespace App\Helpers;
use App\Helpers\ShoppingCart\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;


class PanelConditions
{
    public static function conditionsFormRequirements(): array
    {
        $result = array();

        $result['products_all'] = Product::whereNull('parent_id')->get();

        return $result;
    }

    public static function createConditionsJSON($request): array
    {
        $input = $request->all();

        //conditions
        # condition "product" : specific products
        #
        #
        $conditions_array = array();

        //condition products in cart
        $conditions_array["product_atleast_count"] = $request->input('product_atleast_count');
        $condition_products_id = $request->input('conditions_products_ids');
        if ($condition_products_id) {
            $conditions_array["product"] = $condition_products_id;
        }

        $conditions_array["product_atleast_one"] = $request->input('product_atleast_one');

        //condition products user bought
        $conditions_array["product_bought_atleast_count"] = $request->input('product_bought_atleast_count');
        $condition_products_id = $request->input('conditions_products_bought_ids');
        if ($condition_products_id) {
            $conditions_array["product_bought"] = $condition_products_id;
        }

        //condition profile
        $conditions_array["profile"] = $request->input('conditions_profile');

        return $conditions_array;
    }

    public static function checkPermissions($condition,$user,$for_coupon=false,$product=null): bool
    {
        $result = true;

        //just in cart conditions
        if ($for_coupon) {
            //check if specific products is set
            if (isset($condition->product) && $product && !in_array($product->id, $condition->product)) {
                $result = false;
            }

            //check conditions for products in cart
            if (isset($condition->product_atleast_count)) {
                //if for specific products set atleast count
                $cart = new Cart(userId: $user->id);
                if (isset($condition->product)) {
                    $temp_count = 0;
                    foreach($cart->getItems() as $item)
                    {
                        if (in_array($item->product_id, $condition->product)) {
                            $temp_count++;
                        }
                    }
                    if ($temp_count<$condition->product_atleast_count) {
                        $result = false;
                    }
                }else{
                    if ($cart->getItems()->count()<$condition->product_atleast_count) {
                        $result = false;
                    }
                }
            }

            //check conditions for products bought by user
            if (isset($condition->product_bought_atleast_count)) {
                //if for specific products set atleast count
                if (isset($condition->product_bought)) {
                    $temp_count = 0;
                    foreach ($condition->product_bought as $my_product_id) {
                        if ($user->has_purchased($my_product_id)) {
                            $temp_count++;
                        }
                    }
                    if ($temp_count<$condition->product_bought_atleast_count) {
                        $result = false;
                    }
                }
            }

        }else{
            //in anouncment conditions
            if (isset($condition->product) && $condition->product) {
                $purchased_one_of_this=false;
                foreach ($condition->product as $key => $value) {
                    if($user->has_purchased($value)){
                        $purchased_one_of_this=true;
                    }
                }
                if (!$purchased_one_of_this) {
                    $result = false;
                }
            }
        }

        if (isset($condition->profile) && $condition->profile) {
            foreach ($condition->profile as $key => $value) {
                if ($value) {
                    /*if (!isset($user->profile->$key)) {
                        $result = false;
                    }else*/
                    if (isset($user->profile->$key) && $user->profile->$key != $value) {
                        $result = false;
                    }
                }
            }
        }

        if (isset($condition->product_atleast_one) && $condition->product_atleast_one) {
            if (!$user->has_purchased_any_of_main_products()) {
                $result = false;
            }
        }

        return $result;
    }
}
