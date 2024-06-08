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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_english')->nullable();
            $table->string('mobile')->unique();
            $table->string('email')->unique()->nullable();
            $table->string('password');

            $table->enum('gender', ['male', 'female'])->nullable();
            $table->integer('grade')->nullable();
            $table->integer('field_of_study')->nullable();
            $table->integer('familiarity_way')->nullable();
            $table->integer('province')->nullable();
            $table->integer('city')->nullable();

            $table->integer('credit')->default(0);

            $table->boolean('verified_by_supporter')->default(false);
            $table->boolean('verified')->default(false);

            $table->unsignedBigInteger('referral_id')->nullable();
            $table->foreign('referral_id')->references('id')->on('referral_codes');

            $table->unsignedTinyInteger('block')->default(0);
            $table->string('block_reason_image')->nullable();
            $table->string('block_reason_description')->nullable();

            $table->unsignedBigInteger('sale_support_id')->nullable();
            $table->foreign('sale_support_id')->references('id')->on('admins');

            $table->decimal('sms_token', 5, 0)->nullable();
            $table->unsignedInteger('sms_this_token_tries')->default(0);
            $table->unsignedInteger('sms_wrong_sms_tries')->default(0)->comment('Count of SMS sent without successful login');
            $table->timestamp('sms_lock_until')->nullable();

            $table->text('sales_description')->nullable();
            $table->text('description')->nullable();
            $table->longText('products_ids_purchased')->nullable();

            //User Profile

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
