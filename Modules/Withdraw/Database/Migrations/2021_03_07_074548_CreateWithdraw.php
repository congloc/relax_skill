<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('action');
            $table->string('withdraw_code');
            $table->string('symbol')->nullable();
            $table->string('output_address')->nullable();
            $table->double('amount')->default(0);
            $table->double('fee')->default(0);
            $table->double('total')->default(0);
            $table->string('txhash')->nullable();
            $table->integer('status')->default(0);
            $table->bigInteger('author_id')->nullable();
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
        Schema::dropIfExists('withdraw');
    }
}
