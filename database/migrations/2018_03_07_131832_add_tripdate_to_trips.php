<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTripdateToTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add a tripdate column to trips
        Schema::table('trips', function(Blueprint $table) {
            $table->date('tripDate');
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
            $table->dropColumn('tripDate');
        });
    }
}
