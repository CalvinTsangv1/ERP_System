<?php

use Illuminate\Database\Seeder;

class OrdersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 10; $i++) {
         DB::table('orders')->insert([
         'regno' => Str::random(10),
         'regstate' => 'VIC',
         'custname' => Str::random(15),
         'custphone' =>rand(88888888, 99999999),
         'vehbrand' => Str::random(10),
         'vehmodel' => Str::random(10),
         'vehyear' => rand(1999, 2019),
         'orderstatus' => 0,
         'serialno' => Str::random(15)
         ]);
        }
    }
}
