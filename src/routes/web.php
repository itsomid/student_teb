<?php

use App\ShoppingCart\CartAdaptor;
use App\ShoppingCart\PackageItem;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::get('testm', function (){
   CartAdaptor::init(1);
//   \App\ShoppingCart\CartAdaptor::addPackage(14, [9, 6, 2]);

   $items = CartAdaptor::getItems();
   dd($items[0]->packageItems, $items[0] instanceof PackageItem);
});
