<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToMonthlyemissionsperschoolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('monthlyemissionsperschool', function(Blueprint $table)
		{
			$table->foreign('institutionID', 'fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('monthlyemissionsperschool', function(Blueprint $table)
		{
			$table->dropForeign('fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1');
		});
	}

}
