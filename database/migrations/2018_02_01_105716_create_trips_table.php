<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTripsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('trips', function(Blueprint $table)
		{
			$table->integer('tripID', true);
			$table->integer('deptID')->index('fk_TRIPS_DEPTSPERINSTITUTION1_idx');
			$table->string('plateNumber', 7)->index('fk_TRIPS_VEHICLES_MV1_idx');
			$table->integer('kilometerReading')->nullable();
			$table->string('remarks', 45)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('trips');
	}

}
