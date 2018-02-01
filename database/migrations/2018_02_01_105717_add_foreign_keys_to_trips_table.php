<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('trips', function(Blueprint $table)
		{
			$table->foreign('deptID', 'fk_TRIPS_DEPTSPERINSTITUTION1')->references('deptID')->on('deptsperinstitution')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('plateNumber', 'fk_TRIPS_VEHICLES_MV1')->references('plateNumber')->on('vehicles_mv')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('trips', function(Blueprint $table)
		{
			$table->dropForeign('fk_TRIPS_DEPTSPERINSTITUTION1');
			$table->dropForeign('fk_TRIPS_VEHICLES_MV1');
		});
	}

}
