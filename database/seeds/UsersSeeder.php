<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $collection = array(
                             ['id'=>1  , 'name'=>'Stanley', 'email'=>'admin@vtc.com', 'branchID'=>1,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'System Administrator', 'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>2  , 'name'=>'Alan',    'email'=>'am@vtc.com',    'branchID'=>2,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Accounting Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>3  , 'name'=>'Chris',   'email'=>'cm@vtc.com',    'branchID'=>3,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Category Manager',     'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>4  , 'name'=>'Peter',   'email'=>'pm@vtc.com',    'branchID'=>4,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Purchasing Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>5  , 'name'=>'William', 'email'=>'wc@vtc.com',    'branchID'=>5,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Warehouse Clerk',      'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>6  , 'name'=>'Raymond', 'email'=>'rm1@vtc.com',   'branchID'=>6,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Restaurant Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>7  , 'name'=>'Robert',  'email'=>'rm2@vtc.com',   'branchID'=>7,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Restaurant Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>8  , 'name'=>'Robin',   'email'=>'rm3@vtc.com',   'branchID'=>8,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Restaurant Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>9  , 'name'=>'Ronald',  'email'=>'rm4@vtc.com',   'branchID'=>9,  'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Restaurant Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                             ['id'=>10 , 'name'=>'Ryan',    'email'=>'rm5@vtc.com',   'branchID'=>10, 'email_verified_at'=>NULL, 'password'=>Hash::make(12345678), 'postTitle'=>'Restaurant Manager',   'remember_token'=>NULL, 'created_at'=>'2020-07-05 18:26:17', 'updated_at'=>'2020-07-05 18:26:17'],
                            );
             
            for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('users')->insert([Arr::get($collection,$i)]);
		}
         
    }
}
