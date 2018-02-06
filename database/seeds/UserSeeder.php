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
            'userTypeName' => "University",
        ]);

        //insert to users
        DB::table('users')->insert([
            'userID' => 1,
            'username' => 'richard',
            'userTypeID' => '1',
            'accountName' => 'richard',
            'email' => str_random(6).'@dlsu.edu.ph',
            'password' => bcrypt('secret'),
        ]);
    }
}
