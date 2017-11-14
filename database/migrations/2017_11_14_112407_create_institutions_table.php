<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateInstitutionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('institutions', function(Blueprint $table)
		{
			$table->integer('institutionID', true);
			$table->string('institutionName', 45);
			$table->integer('schoolTypeID')->index('fk_INSTITUTIONS_SCHOOLTYPE_REF_idx');
			$table->string('location', 45)->nullable();
			$table->primary(['institutionID','institutionName']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('institutions');
	}

}
