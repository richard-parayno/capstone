<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMpgToCartypeRef extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //add mpg to cartype_ref
        Schema::table('cartype_ref', function(Blueprint $table){
            $table->decimal('mpg', 8, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //remove mpg from cartype_ref
        Schema::table('cartype_ref', function(Blueprint $table){
            $table->dropColumn('mpg');
        });
    }
}
