<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([SupplierSeeder::class,
					 BranchSeeder::class,
				   //StaffSeeder::class,
					 UsersSeeder::class,
					 ItemCategorySeeder::class,
					 ItemSeeder::class,
					 AgreementHeaderSeeder::class,
					 AgreementLineSeeder::class,
					 AgreementPriceBreakSeeder::class,
					 BranchItem::class,
					 NotificationSeeder::class,
				   //OrdersSeeder::class,
				   //OrderDetailsSeeder::class,
					PurchaseRequestSeeder::class,
				   //PurchaseOrderSeeder::class,
					]);
    }
}
