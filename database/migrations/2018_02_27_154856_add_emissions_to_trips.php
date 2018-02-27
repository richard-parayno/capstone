<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEmissionsToTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add emissions to trips table
        Schema::table('trips', function(Blueprint $table){
            $table->double('emissions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove emissions from trips table
        Schema::table('trips', function(Blueprint $table){
            $table->dropColumn('emissions');
        });
    }
}
