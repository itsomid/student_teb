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
        Schema::create('teacher_commission_change_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_id')->constrained('admins');
            $table->foreignId('product_id')->constrained('products');
            $table->unsignedTinyInteger('product_percentage');
            $table->unsignedTinyInteger('tax_block_percentage');
            $table->json('all_data')->nullable();
            $table->foreignId('changed_by')->constrained('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_commission_change_histories');
    }
};
