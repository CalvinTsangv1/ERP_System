<?php

use Illuminate\Database\Seeder;

class OrderDetailsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
         DB::table('orderdetails')->insert([
         'desc' => Str::random(10),
         'cost' => rand(200, 1000),
         'price' => rand(200, 1000),
         'orderid' => rand(1,10)
         ]);
        }
    }
}
