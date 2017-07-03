<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');

            $table->timestamps();
        });
        Schema::create('tagged', function (Blueprint $table) {
            $table->increments('tag_id');
            $table->integer('taggable_id')->unsigned();
            $table->string('taggable_type', 200)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tagged');
        Schema::dropIfExists('tags');
    }
}
