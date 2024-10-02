<?php

namespace App\Legacy\Listeners;

use App\Legacy\Listeners\Contract\LegacyContract;
use App\Models\CustomPackage;
use App\Models\CustomPackageItem;

class NexusSavePackage implements LegacyContract
{

    public function handle($data): void
    {
        foreach ($data as $package) {

            $pack= CustomPackage::query()->where('id', $package->custom_packages->id)->first();

            $pack = $pack != null
                ?  $pack
                :  new CustomPackage();



            $pack->id           = $package->custom_packages->id;
            $pack->product_id   = $package->custom_packages->product_id;
            $pack->section_name = $package->custom_packages->section_name;
            $pack->created_at   = $package->custom_packages->created_at;
            $pack->updated_at   = $package->custom_packages->updated_at;

            $pack->save();

            $existProducts = CustomPackageItem::query()
                ->where('custom_package_id ',  $pack->id)
                ->get()
                ->pluck('product_id')
                ->toArray();


            $legacyProducts= $package['custom_package_items'];

            $shouldBeDeletedItems= array_diff($existProducts,$legacyProducts);
            $shouldBeCreatedItems= array_diff($legacyProducts,$existProducts);


            CustomPackageItem::query()
                ->where('custom_package_id ',  $pack->id)
                ->whereIn('product_id',$shouldBeDeletedItems)
                ->delete();

            foreach ($shouldBeCreatedItems as $item) {
                CustomPackageItem::query()->create([
                    'custom_package_id' => $pack->id,
                    'product_id'        =>$item,
                ]);
            }
        }

    }
}
