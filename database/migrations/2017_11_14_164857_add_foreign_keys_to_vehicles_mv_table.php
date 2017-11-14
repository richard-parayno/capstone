<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToVehiclesMvTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('vehicles_mv', function(Blueprint $table)
		{
			$table->foreign('carBrandID', 'fk_VEHICLES_MV_CARBRAND_REF1')->references('carBrandID')->on('carbrand_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('carTypeID', 'fk_VEHICLES_MV_CARTYPE_REF1')->references('carTypeID')->on('cartype_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('fuelTypeID', 'fk_VEHICLES_MV_FUELTYPE_REF1')->references('fuelTypeID')->on('fueltype_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('institutionID', 'fk_VEHICLES_MV_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('vehicles_mv', function(Blueprint $table)
		{
			$table->dropForeign('fk_VEHICLES_MV_CARBRAND_REF1');
			$table->dropForeign('fk_VEHICLES_MV_CARTYPE_REF1');
			$table->dropForeign('fk_VEHICLES_MV_FUELTYPE_REF1');
			$table->dropForeign('fk_VEHICLES_MV_INSTITUTIONS1');
		});
	}

}
