<?php

use App\Models\Coupon;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedInteger('vat_tax');
            $table->unsignedInteger('total_payable_price');
            $table->unsignedInteger('final_price');
            $table->unsignedInteger('total_discount');
            $table->unsignedInteger('repayment_count');
            $table->string('status');
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table){
            $table->id();
            $table->foreignIdFor(Order::class)
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignIdFor(Product::class)
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(Coupon::class)
                ->nullable()
                ->constrained()
                ->restrictOnDelete();

            $table->unsignedInteger('final_price');
            $table->unsignedInteger('product_price');
            $table->unsignedInteger('discount_price');
            $table->timestamps();
;        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_items');
    }
};
