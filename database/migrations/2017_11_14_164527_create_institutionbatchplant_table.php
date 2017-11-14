<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstitutionbatchplantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institutionbatchplant', function(Blueprint $table)
		{
			$table->integer('batchPlantID', true);
			$table->integer('institutionID')->index('fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1_idx');
			$table->integer('numOfPlantedTrees')->nullable();
			$table->date('datePlanted')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('institutionbatchplant');
	}

}
