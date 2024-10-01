<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\Product;


class NexusSaveProduct implements LegacyContract
{
    public function handle(object $data): void
    {
        $product = Product::query()->where('id', $data->id)->first();

        $newProduct = is_null($product)
            ?  new Product()
            :  $product;

        $newProduct->id                      = $data->id;
        $newProduct->parent_id               = $data->parent_id;
        $newProduct->product_type_id         = $data->product_type_id;
        $newProduct->user_id                 = $data->user_id;
        $newProduct->name                    = $data->name;
        $newProduct->description             = $data->description;
        $newProduct->original_price          = $data->original_price;
        $newProduct->off_price               = $data->off_price;
        $newProduct->options                 = json_encode($data->options);
        $newProduct->sort_num                = $data->sort_num;
        $newProduct->img_filename            = $data->img_filename;
        $newProduct->is_purchasable          = $data->is_purchasable;
        $newProduct->has_installment         = $data->has_installment;
        $newProduct->installment_count       = $data->installment_count;
        $newProduct->first_installment_ratio = $data->first_installment_ratio;
        $newProduct->final_installment_date  = $data->final_installment_date;
        $newProduct->subscription_start_at   = $data->subscription_start_at;
        $newProduct->show_in_list            = $data->show_in_list;
        $newProduct->archived                = $data->archived;
        $newProduct->expiration_duration     = $data->expiration_duration;
        $newProduct->created_at              = $data->created_at ?? null;
        $newProduct->updated_at              = $data->updated_at ?? null;


        $newProduct->save();
    }
}
