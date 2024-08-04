<?php

use App\Models\Classes;
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
        Schema::create('class_blocks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained(table: 'users')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained(table: 'classes', column: 'product_id')->cascadeOnDelete();
            $table->text('description')->nullable();
            $table->timestamp('expired_at');
            $table->index(['student_id', 'user_id', 'expired_at']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('class_blocks');
    }
};
