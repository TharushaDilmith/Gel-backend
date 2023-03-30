<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropCourseIdFromResources extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resources', function (Blueprint $table) {
            // remove "resources_course_id_foreign" constraint
            $table->dropForeign('resources_course_id_foreign');
            $table->dropColumn('course_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resources', function (Blueprint $table) {
            // add the course_id column
            $table->unsignedBigInteger('course_id');
            // add "resources_course_id_foreign" constraint
            $table->foreign('course_id')->references('id')->on('courses');
        });
    }
}
