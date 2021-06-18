<?php

use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$collection = array(['supplierID'=>1, 'name'=>'Kin Yip Ind Co', 'contactPerson'=>'Ada', 'telephone'=>31028340, 'address'=>'Kam Chong Ind Bldg, Kwai Chung', 'status'=>'Active'],
							['supplierID'=>2, 'name'=>'King Sun Ind Co Ltd', 'contactPerson'=>'Adelaide', 'telephone'=>24630883, 'address'=>'1/F., Yee Wah Industrial Building, 18 San On Street, Tuen Mun', 'status'=>'Active'],
							['supplierID'=>3, 'name'=>'Kwong Wing Food Industries Stainless Steel Engrg Ltd', 'contactPerson'=>'Barbara', 'telephone'=>27713438, 'address'=>'169 Reclamation St, Yau Ma Tei', 'status'=>'Active'],
							['supplierID'=>4, 'name'=>'Lung Sang Plastic Fastfood Utensil Fty', 'contactPerson'=>'Betty', 'telephone'=>24636752, 'address'=>'Yau Tak Ind Bldg, Tuen Mun', 'status'=>'Active'],
							['supplierID'=>5, 'name'=>'Man Kee Chopping Board', 'contactPerson'=>'Cherry', 'telephone'=>23322784, 'address'=>'342 Shanghai St, Yau Ma Tei', 'status'=>'Active'],
							['supplierID'=>6, 'name'=>'Newgen Catering Equip (HK) Ltd', 'contactPerson'=>'Cora', 'telephone'=>24547711, 'address'=>'Capilano Ct, Sha Tin', 'status'=>'Inactive'],
							['supplierID'=>7, 'name'=>'Optitable Technology Ltd', 'contactPerson'=>'Debby', 'telephone'=>26512328, 'address'=>'Fook Yip Ind Bldg, Kwai Chung', 'status'=>'Active'],
							['supplierID'=>8, 'name'=>'Palamon (Internatl) Ltd', 'contactPerson'=>'Diana', 'telephone'=>25449091, 'address'=>'38 Bel-Air Ave, Wah Fu', 'status'=>'Active'],
							['supplierID'=>9, 'name'=>'Scenery Rest Supply Co', 'contactPerson'=>'Eden', 'telephone'=>23410466, 'address'=>'10 Sze Pei Sq, Tsuen Wan', 'status'=>'Active'],
							['supplierID'=>10,'name'=> 'Shine Bros Ltd', 'contactPerson'=>'Ella', 'telephone'=>21274127, 'address'=>'Corporation Park, Sha Tin', 'status'=>'Active'],
						   );
						
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('supplier')->insert([Arr::get($collection,$i)]);
		}
	}
}
