<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('users')->insert([
            'uid' => Str::uuid(),
            'role' => User::RH,
            'name' => Str::random(10),
            'email' => 'rh@gmail.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'uid' => Str::uuid(),
            'role' => User::SH,
            'name' => Str::random(10),
            'email' => 'sh@gmail.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);

        DB::table('users')->insert([
            'uid' => Str::uuid(),
            'role' => User::ADMIN,
            'name' => "Vic",
            'email' => 'vic@youuxi.com',
            'password' => bcrypt('123456'),
            'email_verified_at' => now()
        ]);
    }
}
