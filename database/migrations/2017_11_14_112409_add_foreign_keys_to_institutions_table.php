<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToInstitutionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('institutions', function(Blueprint $table)
		{
			$table->foreign('schoolTypeID', 'fk_INSTITUTIONS_SCHOOLTYPE_REF')->references('schoolTypeID')->on('schooltype_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('institutions', function(Blueprint $table)
		{
			$table->dropForeign('fk_INSTITUTIONS_SCHOOLTYPE_REF');
		});
	}

}
