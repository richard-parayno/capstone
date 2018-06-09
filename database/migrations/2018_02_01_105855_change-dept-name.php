<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDeptName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deptsperinstitution', function (Blueprint $table) {
            //
            $table->string('deptName', 90)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('deptsperinstitution', function (Blueprint $table) {
            $table->string('deptName', 45)->change();            
        });
    }
}
