<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('detection_logs', function (Blueprint $table) {
            $table->string('path')->nullable()->after('mac_address');
            $table->string('source')->nullable()->after('path');
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
            $table->dropColumn(['path', 'source']);
        });
    }
};
