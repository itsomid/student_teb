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
        Schema::create('supports_allocation_rates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('sale_support_id');
            $table->foreign('sale_support_id')->references('id')->on('admins');

            $table->double('allocation_rate')->default(1);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('supports_allocation_rates');
    }
};
