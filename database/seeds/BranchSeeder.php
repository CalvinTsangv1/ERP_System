<?php

use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
		 
    public function run()
    {
		$collection = array(['branchID'=>1,  'name'=>'IT Department',		   'type'=>'',         'telephone'=>23452345, 'address'=>'Headquarters'],
							['branchID'=>2,	 'name'=>'Accounting Department',  'type'=>'',         'telephone'=>23452345, 'address'=>'Headquarters'],
							['branchID'=>3,  'name'=>'Marketing Department',   'type'=>'',         'telephone'=>23452346, 'address'=>'Headquarters'],
							['branchID'=>4,  'name'=>'Purchasing Department',  'type'=>'',         'telephone'=>23452347, 'address'=>'Headquarters'],
							['branchID'=>5,  'name'=>'Warehouse',              'type'=>'',         'telephone'=>23452348, 'address'=>'Kerry TC Warehouse 1, 3 Kin Chuen Street, Kwai Chung, Hong Kong'],
							['branchID'=>6,  'name'=>'FAB Kitchen',            'type'=>'Western',  'telephone'=>23712777, 'address'=>'Shop 704, 7/F, Elite Industrial Centre, 883 Cheung Sha Wan Road, Lai Chi Kok'],
							['branchID'=>7,  'name'=>'Outdark',                'type'=>'Korean',   'telephone'=>28920877, 'address'=>'2/F, Fee Tat Commercial Centre, 613 Nathan Road, Mong Kok'],
							['branchID'=>8,  'name'=>'Bellevue Bar and Grill', 'type'=>'Western',  'telephone'=>23860338, 'address'=>'23/F, Grand Place, 558-560 Nathan Road, Mong Kok'],
							['branchID'=>9,  'name'=>'HAND3AG',                'type'=>'Japanese', 'telephone'=>39070188, 'address'=>'Shop B226-B227A, B2/F, K11 Art Mall, 18 Hanoi Road, Tsim Sha Tsui'],
							['branchID'=>10, 'name'=>'Amitie Kitchen',         'type'=>'Italian',  'telephone'=>31049234, 'address'=>'9/F, H8, 8 Hau Fook Street, Tsim Sha Tsui'],
						);
		
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('branch')->insert([Arr::get($collection,$i)]);
		}   
    }
}
