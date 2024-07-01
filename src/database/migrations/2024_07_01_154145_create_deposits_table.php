<?php

use App\Models\Admin;
use App\Models\Transaction;
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
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->string('deposit_type'); // card_to_card installment
            $table->foreignIdFor(Transaction::class)
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->restrictOnDelete();
            $table->foreignIdFor(Admin::class)
                ->nullable()
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
        Schema::dropIfExists('deposits');
    }
};
