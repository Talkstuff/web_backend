<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('type');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('source');

            $table->boolean('blocked')->default(false);
            $table->boolean('featured')->default(false);
            $table->integer('privacy')->default(\Modules\Media\Models\Media::PRIVACY_FRIENDS);

            $table->integer('downloads')->default(0);
            $table->integer('views')->default(0);
            $table->integer('shares')->default(0);
            $table->integer('likes')->default(0);
            $table->integer('dislikes')->default(0);

            $table->longText('metadata')->nullable();

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
        Schema::dropIfExists('media');
    }
}
