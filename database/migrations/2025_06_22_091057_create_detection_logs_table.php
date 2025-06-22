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
        Schema::create('detection_logs', function (Blueprint $table) {
            $table->id();
            $table->string('pc_name');
            $table->string('user_name');
            $table->string('app_name');
            $table->string('ip_address')->nullable();
            $table->string('mac_address')->nullable();
            $table->timestamp('detected_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detection_logs');
    }
};
