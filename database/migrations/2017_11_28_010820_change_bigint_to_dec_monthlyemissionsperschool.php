<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeBigintToDecMonthlyemissionsperschool extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('monthlyemissionsperschool', function($table) {
            $table->decimal('emission', 8, 4)->nullable()->change();
            $table->integer('monthYear')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cartype_ref', function($table) {
            $table->bigInteger('emissions')->change();
            $table->date('monthYear')->change();
        });
    }
}
