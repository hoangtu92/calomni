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
            'name' => "Java",
            'test_command' => 'java -v',
            'run_command' => 'java',
            'expected_value' => 'java',
            'unexpected_value' => 'Error',
            'thumbnail' => '/uploads/programme/java.png'
        ]);

        DB::table("software")->insert([
            'name' => "Perl",
            'test_command' => 'which perl',
            'run_command' => '',
            'expected_value' => 'perl',
            'unexpected_value' => 'Error',
            'thumbnail' => '/uploads/programme/perl_fd.png'
        ]);

    }
}
