<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfrMediaAttachmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afr_media_attachments', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('applicant_id')->unsigned();
            $table->foreign('applicant_id')->references('id')->on('afr_applicants')->onDelete('cascade');

            $table->string('source');

            $table->string('type')->default('image');

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
        Schema::dropIfExists('afr_media_attachments');
    }
}
