<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChargeTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title',200);
            $table->timestamps();
        });

        Schema::create('charge_type', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('frequency')->nullable();

            $table->integer('transaction_type_id')->unsigned();
            $table->foreign('transaction_type_id')->references('id')->on('transaction_type')->onDelete('cascade');

            $table->integer('wallet_type_id')->unsigned();
            $table->foreign('wallet_type_id')->references('id')->on('wallet_type')->onDelete('cascade');

            $table->float('amount')->nullable();
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
        Schema::dropIfExists('charge_type');
        Schema::dropIfExists('transaction_type');

    }
}
