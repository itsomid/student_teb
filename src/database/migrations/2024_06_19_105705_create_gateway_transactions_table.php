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
        Schema::create('gateway_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete()->nullable();

            $table->string('port', 30);
            $table->unsignedBigInteger('price');

            $table->string('ref_id',100)                          ->nullable();
            $table->string('tracking_code',50)                    ->nullable();
            $table->string('card_number',50)                      ->nullable();
            $table->string('urlid',191)                           ->nullable();
            $table->enum('status',['INIT','SUCCEED','FAILED','REVERSED'])->nullable();
            $table->string('ip', 20)                              ->nullable();
            $table->text('description')                                  ->nullable();
            $table->timestamp('payment_date')                            ->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gateway_transactions');
    }
};
