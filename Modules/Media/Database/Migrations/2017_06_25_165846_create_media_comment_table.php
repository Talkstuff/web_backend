<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaCommentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media-comments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('media_id')->unsigned();
            $table->foreign('media_id')->references('id')->on('media')->onDelete('cascade');

            $table->boolean('blocked')->default(false);

            $table->integer('sender_id')->unsigned();
            $table->foreign('sender_id')->references('id')->on('users')->onDelete('cascade');

            $table->longText('comment')->nullable();

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
        Schema::dropIfExists('media-comments');
    }
}
