<?php

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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->unique()
                ->constrained()
                ->restrictOnDelete();
            $table->unsignedInteger('balance');
            $table->unsignedInteger('gift_amount')->default(0);
            $table->unsignedInteger('withdrawal_amount'); // withdrawal_amount = balance - gift_amount
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
