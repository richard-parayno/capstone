<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class GenerateSchema extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Generate initial schema
        Schema::create('carbrand_ref', function(Blueprint $table)
		{
			$table->integer('carBrandID', true);
			$table->string('carBrandName', 45)->nullable();
        });
        
        Schema::create('cartype_ref', function(Blueprint $table)
		{
			$table->integer('carTypeID', true);
			$table->string('carTypeName', 45)->nullable();
        });
        
        Schema::create('deptsperinstitution', function(Blueprint $table)
		{
			$table->integer('deptID', true);
			$table->integer('institutionID')->index('fk_DEPARTMENTSPERINSTITUTION_INSTITUTIONS1_idx');
			$table->string('deptName', 45)->nullable();
			$table->integer('motherDeptID')->nullable()->index('fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITUTION1_idx');
        });
        
        Schema::create('fueltype_ref', function(Blueprint $table)
		{
			$table->integer('fuelTypeID', true);
			$table->string('fuelTypeName', 45)->nullable();
        });
        
        Schema::create('institutionbatchplant', function(Blueprint $table)
		{
			$table->integer('batchPlantID', true);
			$table->integer('institutionID')->index('fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1_idx');
			$table->integer('numOfPlantedTrees')->nullable();
			$table->date('datePlanted')->nullable();
        });
        
        Schema::create('institutions', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('institutionID');
			$table->string('institutionName', 45);
			$table->integer('schoolTypeID')->index('fk_INSTITUTIONS_SCHOOLTYPE_REF_idx');
			$table->string('location', 45)->nullable();
            $table->timestamps();
        });
        
        Schema::create('password_resets', function(Blueprint $table)
		{
			$table->string('email')->index();
			$table->string('token');
			$table->dateTime('created_at')->nullable();
        });

        Schema::create('monthlyemissions', function(Blueprint $table)
		{
			$table->date('MONTHYEAR')->primary();
			$table->bigInteger('emission')->nullable();
        });
        
        Schema::create('monthlyemissionsperschool', function(Blueprint $table)
		{
			$table->date('monthYear')->primary();
			$table->integer('institutionID')->index('fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1_idx');
			$table->bigInteger('emission')->nullable();
        });

        Schema::create('schooltype_ref', function(Blueprint $table)
		{
			$table->integer('schoolTypeID', true);
			$table->string('schoolTypeName', 45)->nullable();
        });

        Schema::create('trips', function(Blueprint $table)
		{
			$table->integer('tripID', true);
			$table->integer('deptID')->index('fk_TRIPS_DEPTSPERINSTITUTION1_idx');
			$table->string('plateNumber', 7)->index('fk_TRIPS_VEHICLES_MV1_idx');
			$table->integer('kilometerReading')->nullable();
			$table->string('remarks', 45)->nullable();
        });
        
        Schema::create('users', function(Blueprint $table)
		{
			$table->increments('userID', true);
			$table->string('username', 45);
			$table->integer('userTypeID')->index('fk_USERS_USERTYPES_REF1_idx');
			$table->string('accountName', 45)->nullable();
			$table->string('email', 45);
			$table->string('password', 45)->nullable();
        });
        
        Schema::create('usertypes_ref', function(Blueprint $table)
		{
			$table->integer('userTypeID', true);
			$table->string('userTypeName', 45)->nullable();
        });
        
        Schema::create('vehicles_mv', function(Blueprint $table)
		{
			$table->string('plateNumber', 7)->primary();
			$table->integer('institutionID')->index('fk_VEHICLES_MV_INSTITUTIONS1_idx');
			$table->integer('carTypeID')->index('fk_VEHICLES_MV_CARTYPE_REF1_idx');
			$table->integer('carBrandID')->index('fk_VEHICLES_MV_CARBRAND_REF1_idx');
			$table->integer('fuelTypeID')->index('fk_VEHICLES_MV_FUELTYPE_REF1_idx');
			$table->string('modelName', 45)->nullable();
			$table->integer('active')->nullable();
        });
        
        Schema::table('deptsperinstitution', function(Blueprint $table)
		{
			$table->foreign('motherDeptID', 'fk_DEPARTMENTSPERINSTITUTION_DEPARTMENTSPERINSTITU1')->references('deptID')->on('deptsperinstitution')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('deptsperinstitution', function(Blueprint $table) {
            $table->foreign('institutionID', 'fk_DEPARTMENTSPERINSTITUTION_INSTITUTIO')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('institutionbatchplant', function(Blueprint $table)
		{
			$table->foreign('institutionID', 'fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('institutionbatchplant', function(Blueprint $table)
		{
			$table->dropForeign('fk_BATCHTREESPLANTEDPERDEPARTMENT_INSTITUTIONS1');
        });
        
        Schema::table('monthlyemissionsperschool', function(Blueprint $table)
		{
			$table->foreign('institutionID', 'fk_MONTHLYEMISSIONSPERSCHOOL_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('trips', function(Blueprint $table)
		{
			$table->foreign('deptID', 'fk_TRIPS_DEPTSPERINSTITUTION1')->references('deptID')->on('deptsperinstitution')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('plateNumber', 'fk_TRIPS_VEHICLES_MV1')->references('plateNumber')->on('vehicles_mv')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('users', function(Blueprint $table)
		{
			$table->foreign('userTypeID', 'fk_USERS_USERTYPES_REF1')->references('userTypeID')->on('usertypes_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('vehicles_mv', function(Blueprint $table)
		{
			$table->foreign('carBrandID', 'fk_VEHICLES_MV_CARBRAND_REF1')->references('carBrandID')->on('carbrand_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('carTypeID', 'fk_VEHICLES_MV_CARTYPE_REF1')->references('carTypeID')->on('cartype_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('fuelTypeID', 'fk_VEHICLES_MV_FUELTYPE_REF1')->references('fuelTypeID')->on('fueltype_ref')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('institutionID', 'fk_VEHICLES_MV_INSTITUTIONS1')->references('institutionID')->on('institutions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
        
        Schema::table('users', function($table) {
            $table->dateTime('updated_at')->nullable();
        });

        Schema::table('users', function($table) {
            $table->dateTime('created_at')->nullable();
        });

        Schema::table('users', function($table) {
            $table->string('password', 60)->nullable()->change();            
        });

        Schema::table('users', function($table) {
            $table->increments('userID', true)->change();                                              
        });

        Schema::table('users', function($table) {
            $table->string('remember_token')->nullable();
        });

        Schema::create('trips', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('institution_batch_plants', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::create('monthly_emissions_per_schools', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->string('status');
        });

        Schema::table('users', function($table) {
            $table->string('status')->default('Active')->change();
        });

        Schema::table('cartype_ref', function($table) {
            $table->integer('mpg')->nullable();
        });

        Schema::table('trips', function($table) {
            $table->decimal('emissions', 8, 4);
        });

        Schema::table('cartype_ref', function($table) {
            $table->decimal('mpg', 2, 2)->nullable()->change();
        });

        Schema::table('cartype_ref', function($table) {
            $table->decimal('mpg', 4, 4)->nullable()->change();
        });

        Schema::table('cartype_ref', function($table) {
            $table->decimal('mpg', 4, 2)->nullable()->change();
        });

        Schema::table('monthlyemissionsperschool', function($table) {
            $table->decimal('emission', 8, 4)->nullable()->change();
            $table->integer('monthYear')->change();
        });

        Schema::table('monthlyemissionsperschool', function($table) {
            $table->string('monthYear')->change();
        });

        Schema::table('trips', function($table) {
            $table->string('emissions')->change();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Reverse generated schema
        Schema::dropIfExists('password_resets');
        Schema::dropIfExists('carbrand_ref');
        Schema::dropIfExists('cartype_ref');
        Schema::dropIfExists('deptsperinstitution');
        Schema::dropIfExists('fueltype_ref');
        Schema::dropIfExists('institutionbatchplant');
        Schema::dropIfExists('institutions');
        Schema::dropIfExists('monthlyemissions');
        Schema::dropIfExists('monthlyemissionsperschool');
        Schema::dropIfExists('schooltype_ref');
        Schema::dropIfExists('trips');
        Schema::dropIfExists('users');
        Schema::dropIfExists('usertypes_ref');
        Schema::dropIfExists('vehicles_mv');
    }
}
