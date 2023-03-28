<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandToCourses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            // add brand id to courses
            $table->unsignedBigInteger('brand')->nullable();
            $table->foreign('brand')->references('id')->on('brands');

            // add awarding body id to courses
            $table->unsignedBigInteger('awarding_body')->nullable();
            $table->foreign('awarding_body')->references('id')->on('awarding_bodies');

            // add resource type to courses
            $table->string('resource_type')->nullable();

            // add course type to courses
            $table->string('course_type')->nullable();

            // add course link
            $table->string('course_link')->nullable();

            // add course validity
            $table->boolean('validity')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
        });
    }
}
