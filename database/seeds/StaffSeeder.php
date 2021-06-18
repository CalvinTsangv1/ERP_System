<?php

use Illuminate\Database\Seeder;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$collection = array(['staffID'=>1, 'branchID'=>1, 'name'=>'Alice', 'postTitle'=>'Accounting Manager', 'password'=>97528158],
							['staffID'=>2, 'branchID'=>2, 'name'=>'Cathy', 'postTitle'=>'Category Manager',  'password'=>63132501],
							['staffID'=>3, 'branchID'=>3, 'name'=>'Pamela','postTitle'=>'Purchasing Manager', 'password'=>25532693],
							['staffID'=>4, 'branchID'=>4, 'name'=>'William', 'postTitle'=>'Warehouse Clerk',  'password'=>13192885],
							['staffID'=>5, 'branchID'=>5, 'name'=>'Rachel', 'postTitle'=>'Restaurant Manager', 'password'=>49318377],
							['staffID'=>6, 'branchID'=>6, 'name'=>'Rae', 'postTitle'=>'Restaurant Manager', 'password'=>25279635],
							['staffID'=>7, 'branchID'=>7, 'name'=>'Rebecca','postTitle'=> 'Restaurant Manager', 'password'=>98679556],
							['staffID'=>8, 'branchID'=>8, 'name'=>'Regina', 'postTitle'=>'Restaurant Manager', 'password'=>65781773],
							['staffID'=>9, 'branchID'=>9, 'name'=>'Renee', 'postTitle'=>'Restaurant Manager', 'password'=>81894731],
							['staffID'=>10,'branchID'=> 10, 'name'=>'Renata', 'postTitle'=>'Restaurant Manager', 'password'=>37604813],
							['staffID'=>11,'branchID'=> 11, 'name'=>'Rita', 'postTitle'=>'Restaurant Manager', 'password'=>18138869],
							['staffID'=>12,'branchID'=> 12, 'name'=>'Riva', 'postTitle'=>'Restaurant Manager', 'password'=>94106219],
							['staffID'=>13,'branchID'=> 13, 'name'=>'Roberta', 'postTitle'=>'Restaurant Manager', 'password'=>58156759],
							['staffID'=>14,'branchID'=> 14, 'name'=>'Rose', 'postTitle'=>'Restaurant Manager', 'password'=>19770768],
							['staffID'=>15,'branchID'=> 15, 'name'=>'Rosalind','postTitle'=> 'Restaurant Manager', 'password'=>67002549],
							['staffID'=>16,'branchID'=> 16, 'name'=>'Rosemary','postTitle'=> 'Restaurant Manager', 'password'=>33016047],
							['staffID'=>17,'branchID'=> 17, 'name'=>'Eoxanne', 'postTitle'=>'Restaurant Manager', 'password'=>86109366],
							['staffID'=>18,'branchID'=> 18, 'name'=>'Ruby', 'postTitle'=>'Restaurant Manager', 'password'=>54887293],
							['staffID'=>19,'branchID'=> 19, 'name'=>'Ruth', 'postTitle'=>'Restaurant Manager', 'password'=>89390290],
							['staffID'=>20,'branchID'=> 20, 'name'=>'Radomil','postTitle'=> 'Restaurant Manager', 'password'=>41439916],
							['staffID'=>21,'branchID'=> 21, 'name'=>'Ralap', 'postTitle'=>'Restaurant Manager', 'password'=>86510976],
							['staffID'=>22,'branchID'=> 22, 'name'=>'Randolph', 'postTitle'=>'Restaurant Manager', 'password'=>13213746],
							['staffID'=>23,'branchID'=> 23, 'name'=>'Ray', 'postTitle'=>'Restaurant Manager', 'password'=>53129844],
							['staffID'=>24,'branchID'=> 24, 'name'=>'Raymond', 'postTitle'=>'Restaurant Manager','password'=> 74207323],
							['staffID'=>25,'branchID'=> 25, 'name'=>'Rein', 'postTitle'=>'Restaurant Manager', 'password'=>11368150],
							['staffID'=>26,'branchID'=> 26, 'name'=>'Reg', 'postTitle'=>'Restaurant Manager', 'password'=>30138762],
							['staffID'=>27,'branchID'=> 27, 'name'=>'Regan', 'postTitle'=>'Restaurant Manager', 'password'=>58262368],
							['staffID'=>28,'branchID'=> 28, 'name'=>'Reginald', 'postTitle'=>'Restaurant Manager', 'password'=>57054543],
							['staffID'=>29,'branchID'=> 29, 'name'=>'Reuben', 'postTitle'=>'Restaurant Manager', 'password'=>94717453],
							['staffID'=>30,'branchID'=> 30, 'name'=>'Rex', 'postTitle'=>'Restaurant Manager', 'password'=>77294445],
							['staffID'=>31,'branchID'=> 31, 'name'=>'Richard', 'postTitle'=>'Restaurant Manager', 'password'=>47902319],
							['staffID'=>32,'branchID'=> 32, 'name'=>'Roberta', 'postTitle'=>'Restaurant Manager', 'password'=>14962309],
							['staffID'=>33,'branchID'=> 33, 'name'=>'Robin','postTitle'=> 'Restaurant Manager', 'password'=>49293742],
							['staffID'=>34,'branchID'=> 34, 'name'=>'Rock', 'postTitle'=>'Restaurant Manager', 'password'=>38969102],
							['staffID'=>35,'branchID'=> 35, 'name'=>'Rod', 'postTitle'=>'Restaurant Manager', 'password'=>71162189],
							['staffID'=>36,'branchID'=> 36, 'name'=>'Roderick', 'postTitle'=>'Restaurant Manager', 'password'=>92358249],
							['staffID'=>37,'branchID'=> 37, 'name'=>'Rodney', 'postTitle'=>'Restaurant Manager', 'password'=>27944022],
							['staffID'=>38,'branchID'=> 38, 'name'=>'Ron', 'postTitle'=>'Restaurant Manager', 'password'=>57824054],
							['staffID'=>39,'branchID'=> 39, 'name'=>'Ronald', 'postTitle'=>'Restaurant Manager', 'password'=>44826335],
							['staffID'=>40,'branchID'=> 40, 'name'=>'Rory', 'postTitle'=>'Restaurant Manager', 'password'=>68342571],
							['staffID'=>41,'branchID'=> 41, 'name'=>'Roy', 'postTitle'=>'Restaurant Manager', 'password'=>54805752],
							['staffID'=>42,'branchID'=> 42, 'name'=>'Royal', 'postTitle'=>'Restaurant Manager', 'password'=>60751409],
							['staffID'=>43,'branchID'=> 43, 'name'=>'Rudolf', 'postTitle'=>'Restaurant Manager', 'password'=>29823781],
							['staffID'=>44,'branchID'=> 44, 'name'=>'Rupert', 'postTitle'=>'Restaurant Manager', 'password'=>60753626],
							['staffID'=>45,'branchID'=> 45, 'name'=>'Ryan', 'postTitle'=>'Restaurant Manager', 'password'=>80842480],
							['staffID'=>46,'branchID'=> 46, 'name'=>'Randy','postTitle'=> 'Restaurant Manager', 'password'=>32270151],
							['staffID'=>47,'branchID'=> 47, 'name'=>'Reed', 'postTitle'=>'Restaurant Manager', 'password'=>53674832],
							['staffID'=>48,'branchID'=> 48, 'name'=>'Richie', 'postTitle'=>'Restaurant Manager', 'password'=>59001545],
							['staffID'=>49,'branchID'=> 49, 'name'=>'Robinson', 'postTitle'=>'Restaurant Manager', 'password'=>55846044],
							['staffID'=>50,'branchID'=> 50, 'name'=>'Roger', 'postTitle'=>'Restaurant Manager', 'password'=>73416382]
							);
							
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('staff')->insert([Arr::get($collection,$i)]);
		}   
	}
}


// Not Used.
// To be dropped.