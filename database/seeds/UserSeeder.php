<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //insert to usertype_ref
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 1,
            'userTypeName' => "System Admin",
        ]);
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 2,
            'userTypeName' => "LIFE-DLSP",
        ]);
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 3,
            'userTypeName' => "Champion",
        ]);
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 4,
            'userTypeName' => "Dispatching Office",
        ]);
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 5,
            'userTypeName' => "Social Action Office",
        ]);
        DB::table('usertypes_ref')->insert([
            'userTypeID' => 6,
            'userTypeName' => "Special User",
        ]);

        //insert to users
        DB::table('users')->insert([
            'userID' => 1,
            'username' => 'richard',
            'userTypeID' => '1',
            'accountName' => 'richard',
            'email' => str_random(6).'@dlsu.edu.ph',
            'password' => bcrypt('secret'),
            'status' => 'Active',
            'remember_token' => '',
        ]);
    }
}
