<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAuditTrailToTrips extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add batch and uploaded_at to trips
        Schema::table('trips', function(Blueprint $table) {
            $table->integer('batch');
            $table->timestamp('uploaded_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //drop batch and uploaded_at to trips
        Schema::table('trips', function(Blueprint $table) {
            $table->dropColumn('batch');
            $table->dropColumn('uploaded_at');
        });
    }
}
