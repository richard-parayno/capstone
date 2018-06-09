<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserIDToId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //change userID to id
        Schema::table('users', function(Blueprint $table){
            $table->renameColumn('userID', 'id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //change id to userID
        Schema::table('users', function(Blueprint $table){
            $table->renameColumn('id', 'userID');
        });
    }
}
