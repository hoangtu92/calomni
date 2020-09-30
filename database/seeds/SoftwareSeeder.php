<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SoftwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table("software")->insert([
            'name' => "Python",
            'test_command' => 'python -V',
            'run_command' => 'python',
            'expected_value' => 'Python',
            'unexpected_value' => 'Error',
            'thumbnail' => '/uploads/programme/python.png'
        ]);


        DB::table("software")->insert([
            'name' => "C",
            'test_command' => 'c++ --version',
            'expected_value' => 'c++',
            'unexpected_value' => 'Error',
            'run_command' => 'compile',
            'thumbnail' => '/uploads/programme/cpp.png'
        ]);

        DB::table("software")->insert([
            'name' => "Java",
            'test_command' => 'java -v',
            'run_command' => 'java',
            'expected_value' => 'java',
            'unexpected_value' => 'Error',
            'thumbnail' => '/uploads/programme/java.png'
        ]);

        DB::table("host_software")->insert([
            "software_id" => 1,
            "host_id" => 2,
            "price" => 100,
            "executable" => true
        ]);

        DB::table("host_software")->insert([
            "software_id" => 2,
            "host_id" => 1,
            "price" => 120,
            "executable" => true
        ]);


        DB::table("host_software")->insert([
            "software_id" => 3,
            "host_id" => 1,
            "price" => 200,
            "executable" => true
        ]);
    }
}
