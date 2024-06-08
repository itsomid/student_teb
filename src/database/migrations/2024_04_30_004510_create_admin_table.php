<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Laravel\Fortify\Fortify;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->id();

            $table->string('mobile', 14)->unique();
            $table->string('email')->unique()->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('password');

            $table->unsignedBigInteger('supervisor_id')->nullable();
            $table->unsignedBigInteger('teacher_id')->nullable()->comment('for personnel with "teacher_assistant" permission');
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();

            if (Fortify::confirmsTwoFactorAuthentication()) {
                $table->timestamp('two_factor_confirmed_at')->nullable();
            }
            $table->boolean('is_active')->default(true);
            $table->enum('gender', ['male', 'female']);
            $table->string('avatar')->nullable();

            $table->string('instagram')->nullable();
            $table->string('telegram') ->nullable();
            $table->string('whatsapp') ->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
