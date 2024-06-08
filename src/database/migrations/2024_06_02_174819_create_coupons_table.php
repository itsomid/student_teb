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
            $table->unsignedInteger('creator_user_id');
            $table->unsignedInteger('consumer_user_id')->nullable();
            $table->unsignedInteger('specific_product_id');

            $table->float('discount_percentage')->nullable();
            $table->unsignedInteger('discount_amount')->nullable();
            $table->unsignedInteger('for_old_users_min_pay')->default(0);

            $table->string('coupon')->index();

            $table->unsignedInteger('number_of_use')->default(0);
            $table->text('conditions')->nullable();

            $table->boolean('is_mass')->nullable();
            $table->boolean('is_disposable')->default(1);
            $table->boolean('is_multiuser')->default(0);
            $table->tinyInteger('has_purchased')->default(2);
            $table->boolean('for_old_users')->default(0);

            $table->timestamp('expired_at')->nullable();
            $table->string('description')->nullable();

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
