<?php

use Illuminate\Database\Seeder;

class BranchItem extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = array(['branchID'=>5, 'itemID'=>6,   'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>31,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>47,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>81,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>82,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>149, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>170, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>185, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>200, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5, 'itemID'=>289, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>5,'itemID'=>520, 'quantity'=>1000, 'lowStockLevel'=>50],                            
                            ['branchID'=>6, 'itemID'=>16,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>87,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>127, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>147, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>155, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>160, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>183, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>192, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>221, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>6, 'itemID'=>241, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>46,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>83,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>112, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>122, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>137, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>143, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>208, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>225, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>315, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>7, 'itemID'=>324, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>4,   'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>33,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>81,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>90,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>109, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>115, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>128, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>210, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>214, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>8, 'itemID'=>253, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>22,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>40,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>47,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>62,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>78,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>105, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>109, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>133, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>149, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>9, 'itemID'=>159, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>19,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>24,  'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>115, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>136, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>163, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>179, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>181, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>194, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>201, 'quantity'=>100, 'lowStockLevel'=>50],
                            ['branchID'=>10,'itemID'=>248, 'quantity'=>100, 'lowStockLevel'=>50],

                        );


		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('branch_item')->insert([Arr::get($collection,$i)]);
		}

    }
}
