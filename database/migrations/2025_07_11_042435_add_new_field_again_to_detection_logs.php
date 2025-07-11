<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detection_logs', function (Blueprint $table) {
            $table->enum('type_software', ['license', 'unlicense'])->nullable()->after('source');
            $table->enum('company', ['itsa', 'itsp'])->nullable()->after('source');
            $table->enum('ownership', ['personal', 'company'])->nullable()->after('source');
            $table->integer('department_id')->nullable()->after('source');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('detection_logs', function (Blueprint $table) {
            $table->dropColumn(['type_software', 'company', 'ownership', 'department_id']);
        });
    }
};
