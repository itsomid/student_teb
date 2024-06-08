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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('parent_id')->nullable();
            $table->unsignedInteger('product_type_id');
            $table->unsignedInteger('user_id')->default(0)->index();

            $table->string('name');
            $table->text('description');

            $table->unsignedInteger('original_price')->default(0);
            $table->unsignedInteger('off_price')->nullable();

            $table->json('options')->nullable();
            $table->unsignedMediumInteger('sort_num')->nullable();
            $table->string('img_filename')->nullable();
            $table->boolean('is_purchasable')->default(1);

            //Installment
            $table->boolean('has_installment')->default(0);
            $table->unsignedSmallInteger('installment_count')->nullable();
            $table->unsignedSmallInteger('first_installment_ratio')->nullable();
            $table->dateTime('final_installment_date')->nullable();
            $table->dateTime('subscription_start_at')->nullable();


            $table->boolean('show_in_list')->default(1);
            $table->boolean('archived')->default(0);
            $table->unsignedSmallInteger('expiration_duration')->nullable();

            $table->softDeletes();
            $table->timestamps();

            $table->index(['parent_id', 'product_type_id', 'is_purchasable', 'archived', 'show_in_list', 'sort_num'], 'index_product_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
