<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('resource_name');
            $table->string('resource_image');
            $table->string('resource_url');
            $table->unsignedBigInteger('awardingbody_id');
            $table->unsignedBigInteger('resourcetype_id');
            $table->unsignedBigInteger('course_id');
            $table->timestamps();

            //foreign keies
            $table->foreign('awardingbody_id')->references('id')->on('awarding_bodies');
            $table->foreign('resourcetype_id')->references('id')->on('resource_types');
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('resources');
    }
}
