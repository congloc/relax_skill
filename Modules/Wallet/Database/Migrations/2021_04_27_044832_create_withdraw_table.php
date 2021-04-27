<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawTable extends Migration
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
            $table->string('action');
            $table->string('withdraw_id');
            $table->string('userid');
            $table->string('symbol');
            $table->string('output_adress');
            $table->integer('rate');
            $table->integer('amount');
            $table->integer('fee');
            $table->integer('total');
            $table->string('txhash');
            $table->integer('status');
            $table->string('author');
            $table->timestamps('created_at');
            $table->timestamps('updated_at');
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
