<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToDeptsperinstitutionTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('deptsperinstitution', function(Blueprint $table)
		{
			$table->foreign('motherDeptID', 'fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITU1')->references('deptID')->on('deptsperinstitution')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('institutionID', 'fk_DEPARTMENTSPERINSTITUTION_INSTITUTIO')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('deptsperinstitution', function(Blueprint $table)
		{
			$table->dropForeign('fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITU1');
			$table->dropForeign('fk_DEPARTMENTSPERINSTITUTION_INSTITUTIO');
		});
	}

}
