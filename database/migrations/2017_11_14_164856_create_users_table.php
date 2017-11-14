<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->integer('userID', true);
			$table->string('username', 45);
			$table->integer('userTypeID')->index('fk_USERS_USERTYPES_REF1_idx');
			$table->string('accountName', 45)->nullable();
			$table->string('email', 45);
			$table->string('password', 45)->nullable();
			$table->primary(['userID','username']);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
