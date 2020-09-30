<?php

use App\Models\Host;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('hosts')->insert([
            'user_id' => 2,
            'name' => "My PC",
            'token' => 'wljgfoehrwiehfgwoiu97y9hfivherewteteifyigif3ytfiugufgỉf3f',
            'os' => 'Ubuntu 18.0.4',
            'cpu_name' => 'Intel Core i5',
            'cpu_freq' => 2.5,
            'cpu_cores' => 4,
            'mem_total' => 16,
            'mem_free' => 12,
            'storage_total' => 900,
            'storage_free' => 190,
            'info' => 'Intel Core i5 / 16GB Ram / 1TB',
            'ip' => '12.23.12.34',
            'mac' => 'D0-37-45-32-EA-57',
            'status' => Host::ACTIVE
        ]);

        DB::table('hosts')->insert([
            'user_id' => 1,
            'name' => "PC 1122",
            'token' => 'aklshfiahgsagflsdiugvsagfkjsdgvlkdsgkjdzbgjtgfhkjjsahfila',
            'os' => "CentOs 7",
            'cpu_name' => 'Intel Core i7',
            'cpu_freq' => 3,
            'cpu_cores' => 6,
            'mem_total' => 16,
            'mem_free' => 10,
            'storage_total' => 900,
            'storage_free' => 500,
            'info' => 'Intel Core i7 / 16GB Ram / 1TB',
            'ip' => '34.180.12.32',
            'mac' => 'D0-34-22-32-EA-54',
            'status' => Host::ACTIVE
        ]);
    }
}
