<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInstitutionbatchplantTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('institutionbatchplant', function(Blueprint $table)
		{
			$table->foreign('institutionID', 'fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('institutionbatchplant', function(Blueprint $table)
		{
			$table->dropForeign('fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1');
		});
	}

}
