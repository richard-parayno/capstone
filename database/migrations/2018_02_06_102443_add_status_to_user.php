<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add status to users table
        Schema::table('users', function(Blueprint $table) {
            $table->string('status', 60);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //revert status to users
        Schema::table('users', function(Blueprint $table) {
            $table->dropColumn('status', 100);
        });
    }
}
