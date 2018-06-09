<?php

use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert to cartype_ref
        DB::table('cartype_ref')->insert([
            'carTypeID' => '1',
            'carTypeName' => 'Car',
        ]);
        DB::table('cartype_ref')->insert([
            'carTypeID' => '2',
            'carTypeName' => 'Bus',
        ]);
        DB::table('cartype_ref')->insert([
            'carTypeID' => '3',
            'carTypeName' => 'Van',
        ]);

        //insert to carbrand_ref
        DB::table('carbrand_ref')->insert([
            'carBrandID' => '1',
            'carBrandName' => 'Toyota',
        ]);
        DB::table('carbrand_ref')->insert([
            'carBrandID' => '2',
            'carBrandName' => 'Mitsubishi',
        ]);
        DB::table('carbrand_ref')->insert([
            'carBrandID' => '3',
            'carBrandName' => 'Subaru',
        ]);
        DB::table('carbrand_ref')->insert([
            'carBrandID' => '4',
            'carBrandName' => 'Ford',
        ]);
        DB::table('carbrand_ref')->insert([
            'carBrandID' => '5',
            'carBrandName' => 'Honda',
        ]);

        //inster to fueltype_ref
        DB::table('fueltype_ref')->insert([
            'fuelTypeID' => '1',
            'fuelTypeName' => 'Diesel',
        ]);
        DB::table('fueltype_ref')->insert([
            'fuelTypeID' => '2',
            'fuelTypeName' => 'Gasoline',
        ]);

        //insert to vehicles_mv
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'USQ254',
            'institutionID' => 1,
            'carTypeID' => 3,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "Hiace S Grandia",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'USQ274',
            'institutionID' => 1,
            'carTypeID' => 2,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "Coaster 30 Seat",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'PIK982',
            'institutionID' => 1,
            'carTypeID' => 2,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "FM657N CC 7.5L",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'ZPZ543',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "Camry 2.0",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'AAQ659',
            'institutionID' => 1,
            'carTypeID' => 2,
            'carBrandID' => 4,
            'fuelTypeID' => 1,
            'modelName' => "County",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'NXI569',
            'institutionID' => 1,
            'carTypeID' => 3,
            'carBrandID' => 2,
            'fuelTypeID' => 1,
            'modelName' => "L300 Versa Van",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'XEX949',
            'institutionID' => 1,
            'carTypeID' => 3,
            'carBrandID' => 3,
            'fuelTypeID' => 1,
            'modelName' => "Passenger",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'PBO525',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 1,
            'fuelTypeID' => 2,
            'modelName' => "Camry 2.4G",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'ZNM935',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 5,
            'fuelTypeID' => 2,
            'modelName' => "Civic",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'DT0288',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 5,
            'fuelTypeID' => 2,
            'modelName' => "Accord",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'UTQ465',
            'institutionID' => 1,
            'carTypeID' => 3,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "Hiace S Grandia",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'ZHA467',
            'institutionID' => 1,
            'carTypeID' => 2,
            'carBrandID' => 3,
            'fuelTypeID' => 1,
            'modelName' => "Truck NQR",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'ZDG442',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 1,
            'fuelTypeID' => 2,
            'modelName' => "Vios",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'XKR200',
            'institutionID' => 1,
            'carTypeID' => 1,
            'carBrandID' => 1,
            'fuelTypeID' => 2,
            'modelName' => "Altis",
            'active' => 1,
        ]);
        DB::table('vehicles_mv')->insert([
            'plateNumber' => 'YY5242',
            'institutionID' => 1,
            'carTypeID' => 3,
            'carBrandID' => 1,
            'fuelTypeID' => 1,
            'modelName' => "Hiace GL Grandia",
            'active' => 1,
        ]);
    }
}
