<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('clients')->insert([
            [
                'client_name' => 'adel',
                'tele' => '01' . mt_rand(100000000, 999999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'client_name' => 'ali',
                'tele' => '01' . mt_rand(100000000, 999999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'client_name' => 'mohammed',
                'tele' => '01' . mt_rand(100000000, 999999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'client_name' => 'guest',
                'tele' => '01' . mt_rand(100000000, 999999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
