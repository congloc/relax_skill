<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecentLogins extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recent_logins', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('ip');
            $table->string('agent');
            $table->string('location');
            $table->string('isp');
            $table->string('browser');
            $table->string('device');
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
        Schema::dropIfExists('recent_logins');
    }
}
