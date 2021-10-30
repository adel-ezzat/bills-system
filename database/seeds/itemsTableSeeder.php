<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class itemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('items')->insert([
            [
                'item_name' => 'item1',
                'quantity' => mt_rand(1, 100),
                'cost_price' => mt_rand(1, 10),
                'sale_price' => mt_rand(20, 30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'item_name' => 'item2',
                'quantity' => mt_rand(1, 100),
                'cost_price' => mt_rand(1, 10),
                'sale_price' => mt_rand(20, 30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ],
            [
                'item_name' => 'item3',
                'quantity' => mt_rand(1, 100),
                'cost_price' => mt_rand(1, 10),
                'sale_price' => mt_rand(20, 30),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
