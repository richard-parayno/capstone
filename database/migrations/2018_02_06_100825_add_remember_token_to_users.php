<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRememberTokenToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add remember token to users
        Schema::table('users', function(Blueprint $table) {
            $table->string('remember_token', 100);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //revert remember token to users
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('remeber_token', 100);
        });
    }
}
