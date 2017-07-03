<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media_categories', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name')->default('Uncategorized');
            $table->integer('type');
            $table->integer('user_id')->nullable(); // group created by user

            $table->longText('metadata')->nullable();
            $table->timestamps();
        });

        Schema::create('media_category_pivot', function (Blueprint $table) {
            $table->integer('media_id')->unsigned(); // group created by user
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');

            $table->integer('category_id')->unsigned(); // group created by user
            $table->foreign('category_id')->references('id')->on('media_categories')->onDelete('cascade');

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
        Schema::dropIfExists('media_category_pivot');
        Schema::dropIfExists('media_categories');
    }
}
