<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SafesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('safes')->insert([
            [
                'name' => 'safe1',
                'money_amount' => mt_rand(100000, 999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'name' => 'safe2',
                'money_amount' => mt_rand(100000, 999999),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
