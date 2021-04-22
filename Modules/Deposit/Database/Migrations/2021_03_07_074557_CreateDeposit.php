<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeposit extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit', function (Blueprint $table) {
            $table->id();
            $table->text('ip')->nullable();
            $table->string('deposit_id')->nullable();
            $table->string('action')->nullable();
            $table->string('symbol')->nullable();
            $table->bigInteger('user_id')->default(0);
            $table->double('amount')->default(0);
            $table->double('fee')->default(0);
            $table->double('rate')->default(1);
            $table->double('total')->default(0);
            $table->integer('status')->default(0);
            $table->string('type')->nullable();
            $table->integer('author')->default(0);
            $table->text('proof_image')->nullable();
            $table->text('proof_reply')->nullable();
            $table->text('txhash')->nullable();
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
        Schema::dropIfExists('deposit');
    }
}
