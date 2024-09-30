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
        Schema::create('card_transactions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_id')
                ->constrained('users')
                ->restrictOnDelete();
            $table->foreignId('transaction_id')
                ->nullable()
                ->constrained('transactions')
                ->restrictOnDelete();

            $table->string('tracking_code');
            $table->unsignedInteger('amount');
            $table->string('status'); // Enum: App\Enums\CardTransactionStatusEnum
            $table->timestamp('paid_date');
            $table->string('filename');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('card_transactions');
    }
};
