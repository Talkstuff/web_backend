<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_type', function (Blueprint $table) {
            $table->increments('id');
            $table->string('currencyName', 100)->unique();
            $table->string('currencySymbol', 10)->unique();
            $table->string('title',100)->unique();
            $table->string('abbreviation',25);
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
        Schema::dropIfExists('wallet_type');
    }
}
