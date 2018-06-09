<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTriptimeToTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add a triptime column to trips
        Schema::table('trips', function(Blueprint $table) {
            $table->time('tripTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove tripdate column from trips
        Schema::table('trips', function(Blueprint $table) {
            $table->dropColumn('tripTime');
        });
    }
}
