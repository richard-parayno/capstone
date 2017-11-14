<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMonthlyemissionsperschoolTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('monthlyemissionsperschool', function(Blueprint $table)
		{
			$table->date('monthYear')->primary();
			$table->integer('institutionID')->index('fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1_idx');
			$table->bigInteger('emission')->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('monthlyemissionsperschool');
	}

}
