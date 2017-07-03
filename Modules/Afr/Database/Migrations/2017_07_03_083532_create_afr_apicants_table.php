<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfrApicantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afr_application_types', function (Blueprint $table) {
            $table->increments('id');

            $table->string('name');

            $table->timestamps();
        });

        Schema::create('afr_applicants', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('type')->unsigned();
            $table->foreign('type_id')->references('id')->on('afr_application_types')->onDelete('cascade');

            $table->string('name');
            $table->string('gender')->nullable();
            $table->string('ip')->unique();
            $table->string('email')->unique();
            $table->string('phone_number');
            $table->string('date_of_birth');
            $table->string('country');

            $table->longText('blog_content')->nullable();

            $table->longText('metadata')->nullable();

            $table->timestamps();
        });

        Schema::create('afr_votes', function (Blueprint $table) {
            $table->integer('applicant_id')->unsigned();
            $table->foreign('applicant_id')->references('id')->on('afr_applicants')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('status')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('afr_votes');
        Schema::dropIfExists('afr_applicants');
        Schema::dropIfExists('afr_application_type');
    }
}
