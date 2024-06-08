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
        Schema::create('user_profile', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->string('national_code', 10)->nullable();
            $table->string('national_code_img_filename')->nullable();
            $table->unsignedTinyInteger('national_code_status')->default(0);
            $table->unsignedTinyInteger('field_of_study')->nullable();
            $table->unsignedTinyInteger('sex')->nullable();

            $table->unsignedSmallInteger('province')->nullable();
            $table->unsignedMediumInteger('city')->nullable();

            $table->string('grade')->nullable();
            $table->unsignedTinyInteger('familiarity_way')->nullable();
            $table->string('img_filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profile');
    }
};
