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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products');

            $table->unsignedBigInteger('course_id');
           // $table->foreign('course_id')->references('id')->on('product_live_courses');

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('classes');

            $table->timestamp('holding_date')   ->nullable();
            $table->string('status', 20) ->nullable();
            $table->integer('sort_num')         ->nullable();
            $table->boolean('is_free')->default(false);

            $table->text('offline_link_woza') ->nullable();
            $table->text('offline_link_vod')  ->nullable();
            $table->text('emergency_link')    ->nullable();
            $table->text('attached_file_link')->nullable();

            $table->text('studio_description')->nullable();

            $table->tinyInteger('qa_is_active')->nullable();

            $table->boolean('homework_is_active')   ->default(false);
            $table->boolean('homework_is_mandatory')->default(false);

            $table->boolean('report_is_mandatory')  ->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
