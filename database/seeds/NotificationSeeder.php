<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class NotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$time = Carbon::now()->toDateTimeString();
        $collection = array(['messageID'=>1,'email'=>'admin@vtc.com','timestamp'=>$time,'subject'=>'test','content'=>'test1','status'=>'Read'],
							['messageID'=>2,'email'=>'admin@vtc.com','timestamp'=>$time,'subject'=>'test','content'=>'test2','status'=>'Unread']);
    
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('notification')->insert([Arr::get($collection,$i)]);
		}   
	}
}
