<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandToResourceTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resource_types', function (Blueprint $table) {
            // add brand id to resource types
            $table->unsignedBigInteger('brand')->nullable();
            $table->foreign('brand')->references('id')->on('brands');
            // add awarding body id to resource types
            $table->unsignedBigInteger('awarding_body')->nullable();
            $table->foreign('awarding_body')->references('id')->on('awarding_bodies');
            // add validity boolean to resource types
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
        Schema::table('resource_types', function (Blueprint $table) {
            //
            $table->dropForeign(['brand']);
            $table->dropColumn('brand');

            $table->dropForeign(['awarding_body']);
            $table->dropColumn('awarding_body');

            $table->dropColumn('validity');
        });
    }
}
