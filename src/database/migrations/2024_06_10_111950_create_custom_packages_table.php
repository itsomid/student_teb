<?php

use App\Models\CustomPackage;
use App\Models\Product;
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
        Schema::create('custom_packages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->cascadeOnDelete();
            $table->string('section_name');
            $table->timestamp('holding_date')->nullable();
            $table->timestamps();
        });

        Schema::create('custom_package_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(CustomPackage::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Product::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_packages');
        Schema::dropIfExists('custom_package_items');
    }
};
