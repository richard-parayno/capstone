<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeRememberTokenToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //change remember token to nullable
        Schema::table('users', function(Blueprint $table){
            $table->string('remember_token', 100)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //reverse change to remember token
        Schema::table('users', function(Blueprint $table){
            $table->string('remember_token', 100)->change();
        });
    }
}
