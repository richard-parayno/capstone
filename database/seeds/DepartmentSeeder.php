<?php

use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        DB::table('schooltype_ref')->insert([
            'schoolTypeID' => 1,
            'schoolTypeName' => "University",
        ]);

        DB::table('institutions')->insert([
            'institutionID' => 1,
            'institutionName' => "De La Salle University - Manila",
            'schoolTypeID' => 1,
            'location' => 'Taft Avenue',
        ]);

    
        DB::table('deptsperinstitution')->insert([
            'deptID' => 1,
            'institutionID' => 1,
            'deptName' => "Office of Sports Development",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 2,
            'institutionID' => 1,
            'deptName' => "Brothers Community",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 3,
            'institutionID' => 1,
            'deptName' => "Procurement Office",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 4,
            'institutionID' => 1,
            'deptName' => "College of Computer Studies",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 5,
            'institutionID' => 1,
            'deptName' => "College of Liberal Arts",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 6,
            'institutionID' => 1,
            'deptName' => "College of Science",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 7,
            'institutionID' => 1,
            'deptName' => "Ramon V. del Rosario College of Business",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 8,
            'institutionID' => 1,
            'deptName' => "Br. Andrew Gonzales College of Education",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 9,
            'institutionID' => 1,
            'deptName' => "School of Economics",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 10,
            'institutionID' => 1,
            'deptName' => "Gokongwei College of Engineering",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 11,
            'institutionID' => 1,
            'deptName' => "Information Technology",
            'motherDeptID' => 4,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 12,
            'institutionID' => 1,
            'deptName' => "Computer Technology",
            'motherDeptID' => 4,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 13,
            'institutionID' => 1,
            'deptName' => "Software Technology",
            'motherDeptID' => 4,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 14,
            'institutionID' => 1,
            'deptName' => "Accounting",
            'motherDeptID' => 7,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 15,
            'institutionID' => 1,
            'deptName' => "Civil Engineering",
            'motherDeptID' => 10,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 16,
            'institutionID' => 1,
            'deptName' => "Central Administration Office",
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 17,
            'institutionID' => 1,
            'deptName' => "Integrated Office of the President and Chancellor",
            'motherDeptID' => 16,            
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 18,
            'institutionID' => 1,
            'deptName' => "Office of the Vice Chancellor for Academics",
            'motherDeptID' => 16,            
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 19,
            'institutionID' => 1,
            'deptName' => "Office of the President and Chancellor",
            'motherDeptID' => 17,            
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 20,
            'institutionID' => 1,
            'deptName' => "Office of the Vice President for Finance",
            'motherDeptID' => 17,            
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 21,
            'institutionID' => 1,
            'deptName' => "Office for the Dean of Student Affairs",          
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 22,
            'institutionID' => 1,
            'deptName' => "Cultural Arts Office",   
            'motherDeptID' => 21,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 23,
            'institutionID' => 1,
            'deptName' => "Student Discipline Formation Office",   
            'motherDeptID' => 21,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 24,
            'institutionID' => 1,
            'deptName' => "Student Media Office",   
            'motherDeptID' => 21,
        ]);
        DB::table('deptsperinstitution')->insert([
            'deptID' => 25,
            'institutionID' => 1,
            'deptName' => "College of Law",   
        ]);

    }
}
