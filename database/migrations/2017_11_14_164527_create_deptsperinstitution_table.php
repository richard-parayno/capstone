<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDeptsperinstitutionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('deptsperinstitution', function(Blueprint $table)
		{
			$table->integer('deptID', true);
			$table->integer('institutionID')->index('fk_DEPARTMENTSPERINSTITUTION_INSTITUTIONS1_idx');
			$table->string('deptName', 45)->nullable();
			$table->integer('motherDeptID')->nullable()->index('fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITUTION1_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('deptsperinstitution');
	}

}
