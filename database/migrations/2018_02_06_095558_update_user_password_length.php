<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateUserPasswordLength extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //update password length
        Schema::table('users', function(Blueprint $table) {
            $table->string('password', 90)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //revert password length
        Schema::table('users', function(Blueprint $table) {
            $table->string('password', 45)->change();
        });
    }
}
