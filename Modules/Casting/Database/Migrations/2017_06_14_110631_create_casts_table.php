<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('cast_categories')) {
            Schema::create('cast_categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
                $table->timestamps();
            });
        }



        if (!Schema::hasTable('casts')) {
            Schema::create('casts', function (Blueprint $table) {
                $table->increments('id');

                $table->integer('category_id')->unsigned();
                $table->foreign('category_id')->references('id')->on('cast_categories')->onDelete('cascade');

                $table->integer('user_id')->unsigned()->nullable();

                $table->string('name');
                $table->string('gender');
                $table->string('email');
                $table->string('phone_number');
                $table->string('date_of_birth');
                $table->string('country');
                $table->string('height');
                $table->string('waist_size');
                $table->string('chest_size');
                $table->string('shoe_size');
                $table->string('hair_colour');
                $table->string('eye_colour');
                $table->boolean('short_listed')->default(false);

                $table->longText('image_attachments')->nullable();
                $table->longText('video_attachments')->nullable();
                $table->longText('metadata')->nullable();

                $table->timestamps();
            });
        }


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('casts');
        Schema::dropIfExists('cast_categories');
    }
}
