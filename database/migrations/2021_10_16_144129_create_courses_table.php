<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->string('url');
            $table->unsignedBigInteger('awardingbody_id');
            $table->unsignedBigInteger('resourcetype_id');
            $table->timestamps();

            //foreign keies
            $table->foreign('awardingbody_id')->references('id')->on('awarding_bodies');
            $table->foreign('resourcetype_id')->references('id')->on('resource_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('courses');
    }

}
