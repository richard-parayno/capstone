<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateVehiclesMvTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('vehicles_mv', function(Blueprint $table)
		{
			$table->string('plateNumber', 7)->primary();
			$table->integer('institutionID')->index('fk_VEHICLES_MV_INSTITUTIONS1_idx');
			$table->integer('carTypeID')->index('fk_VEHICLES_MV_CARTYPE_REF1_idx');
			$table->integer('carBrandID')->index('fk_VEHICLES_MV_CARBRAND_REF1_idx');
			$table->integer('fuelTypeID')->index('fk_VEHICLES_MV_FUELTYPE_REF1_idx');
			$table->string('modelName', 45)->nullable();
			$table->integer('active')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('vehicles_mv');
	}

}
