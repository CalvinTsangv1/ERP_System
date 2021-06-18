<?php

use Illuminate\Database\Seeder;

class PurchaseOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {//
 $collection = array(
                    [/*'poNo'=>1, 'requestID'=>1, 'agreementID'=>'1', 'revision'=>'1', 'releaseNo'=>'1', 'supplierID'=>'42', 'type'=>'Blanket Purchase Release', 'status'=>'Pending for Delivery', 'quotationNo'=>'1', 'createdDate'=>'2020-07-12', 'account'=>'12345678', 'shipmentAddress'=>'SomeWhere'*/],
                    );
       
        
    	for($i=0; $i<count($collection); $i++) {
    		//for debug input data error
    		//print_r(Arr::get($collection,$i));
    		DB::table('purchase_order')->insert([Arr::get($collection,$i)]);
    	}   
    }    
}
