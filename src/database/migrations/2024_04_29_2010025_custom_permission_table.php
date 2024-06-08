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
        $tableNames = config('permission.table_names');
        if (empty($tableNames))
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->string('persian_name')->after('name')         ->nullable();
            $table->string('description') ->after('persian_name') ->nullable();
        });

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->string('persian_name') ->after('name') ->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tableNames = config('permission.table_names');
        if (empty($tableNames))
            throw new \Exception('Error: config/permission.php not loaded. Run [php artisan config:clear] and try again.');

        Schema::table($tableNames['permissions'], function (Blueprint $table) {
            $table->dropColumn('persian_name');
            $table->dropColumn('description');
        });

        Schema::table($tableNames['roles'], function (Blueprint $table) {
            $table->dropColumn('persian_name');
        });
    }
};
