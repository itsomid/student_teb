<?php

use App\Models\Admin;
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
        Schema::create('teacher_product_commissions', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('product_percentage');
            $table->unsignedTinyInteger('tax_block_percentage');

            $table->foreignId('teacher_id')
                ->constrained('admins')
                ->restrictOnDelete();
            $table->foreignId('product_id')
                ->unique()
                ->constrained()
                ->restrictOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_product_commissions');
    }
};
