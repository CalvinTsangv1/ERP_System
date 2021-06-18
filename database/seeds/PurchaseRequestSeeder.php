<?php

use Illuminate\Database\Seeder;

class PurchaseRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = array(
            ['requestID'=>1, 'branchID'=>6,  'createdDate'=>'2020-07-12', 'expectedDeliveryDate'=>'2020-07-31', 'status'=>'Pending for Mapping', 'remarks'=>'Empty'],
            ['requestID'=>2, 'branchID'=>7,  'createdDate'=>'2020-07-12', 'expectedDeliveryDate'=>'2020-07-31', 'status'=>'Pending for Mapping', 'remarks'=>'Empty'],
            ['requestID'=>3, 'branchID'=>8,  'createdDate'=>'2020-07-12', 'expectedDeliveryDate'=>'2020-07-31', 'status'=>'Pending for Mapping', 'remarks'=>'Empty'],
            ['requestID'=>4, 'branchID'=>9,  'createdDate'=>'2020-07-12', 'expectedDeliveryDate'=>'2020-07-31', 'status'=>'Pending for Mapping', 'remarks'=>'Empty'],
            ['requestID'=>5, 'branchID'=>10, 'createdDate'=>'2020-07-12', 'expectedDeliveryDate'=>'2020-07-31', 'status'=>'Pending for Mapping', 'remarks'=>'Empty'],
        );
       
        
    	for($i=0; $i<count($collection); $i++) {
    		//for debug input data error
    		//print_r(Arr::get($collection,$i));
    		DB::table('purchase_request')->insert([Arr::get($collection,$i)]);
    	}   
    }
}
