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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type');
            $table->string('key');
            $table->boolean('archived')->default(false);
            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table){

            $table->foreignId('product_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('category_id')
                ->constrained()
                ->restrictOnDelete()
                ->cascadeOnUpdate();

            $table->unique(['product_id', 'category_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
        Schema::dropIfExists('product_category_products');
    }
};
