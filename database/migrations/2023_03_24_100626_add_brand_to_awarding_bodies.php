<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBrandToAwardingBodies extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('awarding_bodies', function (Blueprint $table) {
            // add brand_id to awarding_bodies table;
            $table->foreign('brand')->references('id')->on('brands');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('awarding_bodies', function (Blueprint $table) {
            // remove brand_id from awarding_bodies table
            $table->dropForeign('awarding_bodies_brand_id_foreign');
            $table->dropColumn('brand');
        });
    }
}
