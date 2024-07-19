<?php

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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('type',40);

            $table->string('coupon_name')->unique()->index();

            $table->string('description')->nullable();

            $table->unsignedInteger('creator_id');

            $table->json('consumer_ids')->nullable();
            $table->json('product_ids')->nullable();;

            $table->float('discount_percentage')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();

            $table->unsignedInteger('number_of_use')->default(0);

            $table->boolean('is_one_time')->default(true)->comment('Indicates whether the discount code is one-time use');

            $table->timestamp('expired_at')->nullable();
            $table->json('conditions')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
