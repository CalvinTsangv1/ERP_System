<?php

use Illuminate\Database\Seeder;

class ItemCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $collection = array(['categoryID'=>1, 'categoryName'=>'General',									'parentCategoryID'=>NULL],
							['categoryID'=>2, 'categoryName'=>'Food & Beverage',							'parentCategoryID'=>NULL],
							['categoryID'=>3, 'categoryName'=>'Tableware',									'parentCategoryID'=>'1'],
							['categoryID'=>4, 'categoryName'=>'Plate',										'parentCategoryID'=>'3'],
							['categoryID'=>5, 'categoryName'=>'Fork',										'parentCategoryID'=>'3'],
							['categoryID'=>6, 'categoryName'=>'Knife',										'parentCategoryID'=>'3'],
							['categoryID'=>7, 'categoryName'=>'Cup',										'parentCategoryID'=>'3'],
							['categoryID'=>8, 'categoryName'=>'Bowl',										'parentCategoryID'=>'3'],
							['categoryID'=>9, 'categoryName'=>'Spoon',										'parentCategoryID'=>'3'],
							['categoryID'=>10,'categoryName'=>'Toothpick',									'parentCategoryID'=>'3'],
							['categoryID'=>11,'categoryName'=>'Candle',										'parentCategoryID'=>'3'],
							['categoryID'=>12,'categoryName'=>'Tablecloth',									'parentCategoryID'=>'3'],
							['categoryID'=>13,'categoryName'=>'Paper Plate',								'parentCategoryID'=>'4'],
							['categoryID'=>14,'categoryName'=>'Plastic Plate',								'parentCategoryID'=>'4'],
							['categoryID'=>15,'categoryName'=>'Paper Cup',									'parentCategoryID'=>'7'],
							['categoryID'=>16,'categoryName'=>'Plastic Cup',								'parentCategoryID'=>'7'],
							['categoryID'=>17,'categoryName'=>'Paper Bowl',									'parentCategoryID'=>'8'],
							['categoryID'=>18,'categoryName'=>'Plastic Bowl',								'parentCategoryID'=>'8'],
							['categoryID'=>19,'categoryName'=>'Other Bowl',									'parentCategoryID'=>'8'],
							['categoryID'=>20,'categoryName'=>'Plastic Spoon',								'parentCategoryID'=>'9'],
							['categoryID'=>21,'categoryName'=>'Other Spoon',								'parentCategoryID'=>'9'],
							['categoryID'=>22,'categoryName'=>'Food',										'parentCategoryID'=>'2'],
							['categoryID'=>23,'categoryName'=>'Canned & Packaged Food',						'parentCategoryID'=>'22'],
							['categoryID'=>24,'categoryName'=>'Rice, Oil, Noodles & Pasta',					'parentCategoryID'=>'22'],
							['categoryID'=>25,'categoryName'=>'Sauces, Condiments & Cooking Ingredients',	'parentCategoryID'=>'22'],
							['categoryID'=>26,'categoryName'=>'Fish & Seafood',								'parentCategoryID'=>'23'],
							['categoryID'=>27,'categoryName'=>'Fruits',										'parentCategoryID'=>'23'],
							['categoryID'=>28,'categoryName'=>'Meat',										'parentCategoryID'=>'23'],
							['categoryID'=>29,'categoryName'=>'Pickles',									'parentCategoryID'=>'23'],
							['categoryID'=>30,'categoryName'=>'Preserved Bean Curd',						'parentCategoryID'=>'23'],
							['categoryID'=>31,'categoryName'=>'Soup',										'parentCategoryID'=>'23'],
							['categoryID'=>32,'categoryName'=>'Vegetables',									'parentCategoryID'=>'23'],
							['categoryID'=>33,'categoryName'=>'Asian Noodles',								'parentCategoryID'=>'24'],
							['categoryID'=>34,'categoryName'=>'Canola & Sunflower Oil',						'parentCategoryID'=>'24'],
							['categoryID'=>35,'categoryName'=>'Corn Oil',									'parentCategoryID'=>'24'],
							['categoryID'=>36,'categoryName'=>'Instant Noodles',							'parentCategoryID'=>'24'],
							['categoryID'=>37,'categoryName'=>'Pasta',										'parentCategoryID'=>'24'],
							['categoryID'=>38,'categoryName'=>'Peanut Oil',									'parentCategoryID'=>'24'],
							['categoryID'=>39,'categoryName'=>'Specialty Rice',								'parentCategoryID'=>'24'],
							['categoryID'=>40,'categoryName'=>'Vegetables & Other Cooking Oil',				'parentCategoryID'=>'24'],
							['categoryID'=>41,'categoryName'=>'White Rice',									'parentCategoryID'=>'24'],
							['categoryID'=>42,'categoryName'=>'Baking & Dessert Needs',						'parentCategoryID'=>'25'],
							['categoryID'=>43,'categoryName'=>'Convenience Sauce',							'parentCategoryID'=>'25'],
							['categoryID'=>44,'categoryName'=>'Curry, Chili, Spicy & XO Sauce',				'parentCategoryID'=>'25'],
							['categoryID'=>45,'categoryName'=>'Ketchup, Pasta Sauce & Tomato Paste',		'parentCategoryID'=>'25'],
							['categoryID'=>46,'categoryName'=>'Pepper, Herbs & Spices',						'parentCategoryID'=>'25'],
							['categoryID'=>47,'categoryName'=>'Salad Dressing, Mayonnaise & Mustard',		'parentCategoryID'=>'25'],
							['categoryID'=>48,'categoryName'=>'Salt, Chicken Powder & MSG',					'parentCategoryID'=>'25'],
							['categoryID'=>49,'categoryName'=>'Sugar & Sweeteners',							'parentCategoryID'=>'25'],
							['categoryID'=>50,'categoryName'=>'Beverage',									'parentCategoryID'=>'2'],
							['categoryID'=>51,'categoryName'=>'Alcoholic Beverages',						'parentCategoryID'=>'50'],
							['categoryID'=>52,'categoryName'=>'Ready-to-drink Beverages',					'parentCategoryID'=>'50'],
							['categoryID'=>53,'categoryName'=>'Asian Wine',									'parentCategoryID'=>'51'],
							['categoryID'=>54,'categoryName'=>'Beer, Stout & Cider',						'parentCategoryID'=>'51'],
							['categoryID'=>55,'categoryName'=>'Brandy, Whisky & Spirit',					'parentCategoryID'=>'51'],
							['categoryID'=>56,'categoryName'=>'Carbonated Drinks',							'parentCategoryID'=>'50'],
							['categoryID'=>57,'categoryName'=>'Energy Drink',								'parentCategoryID'=>'50'],
							['categoryID'=>58,'categoryName'=>'Juice & Cordials',							'parentCategoryID'=>'50'],
							['categoryID'=>59,'categoryName'=>'Milk & Yogurt Drinks',						'parentCategoryID'=>'50'],
							['categoryID'=>60,'categoryName'=>'Soya Drinks',								'parentCategoryID'=>'50'],
							['categoryID'=>61,'categoryName'=>'Water',										'parentCategoryID'=>'50'],
							['categoryID'=>62,'categoryName'=>'Fresh Food',									'parentCategoryID'=>'22'],
							['categoryID'=>63,'categoryName'=>'Fruits',										'parentCategoryID'=>'62'],
							['categoryID'=>64,'categoryName'=>'Meat & Poultry',								'parentCategoryID'=>'62'],
							['categoryID'=>65,'categoryName'=>'Vegetables & Potatoes',						'parentCategoryID'=>'62'],
							['categoryID'=>66,'categoryName'=>'Apples & Pears',								'parentCategoryID'=>'63'],
							['categoryID'=>67,'categoryName'=>'Bananas',									'parentCategoryID'=>'63'],
							['categoryID'=>68,'categoryName'=>'Grapes & Berries',							'parentCategoryID'=>'63'],
							['categoryID'=>69,'categoryName'=>'Melon',										'parentCategoryID'=>'63'],
							['categoryID'=>70,'categoryName'=>'Beef',										'parentCategoryID'=>'64'],
							['categoryID'=>71,'categoryName'=>'Chicken & Turkey',							'parentCategoryID'=>'64'],
							['categoryID'=>72,'categoryName'=>'Mushrooms',									'parentCategoryID'=>'65'],
							['categoryID'=>73,'categoryName'=>'Patatoes',									'parentCategoryID'=>'65'],
							['categoryID'=>74,'categoryName'=>'Root Vegetables',							'parentCategoryID'=>'65'],
							['categoryID'=>75,'categoryName'=>'Salad Vegetables',							'parentCategoryID'=>'65'],
							['categoryID'=>76,'categoryName'=>'Spices',										'parentCategoryID'=>'65'],
							['categoryID'=>77,'categoryName'=>'Others',										'parentCategoryID'=>'65'],
							['categoryID'=>78,'categoryName'=>'Frozen Food',								'parentCategoryID'=>'22'],
							['categoryID'=>79,'categoryName'=>'Fish & Seafood',								'parentCategoryID'=>'78'],
							['categoryID'=>80,'categoryName'=>'Meat & Poultry',								'parentCategoryID'=>'78'],
							['categoryID'=>81,'categoryName'=>'Vegetables & Fruits',						'parentCategoryID'=>'78'],
							['categoryID'=>82,'categoryName'=>'Fish',										'parentCategoryID'=>'79'],
							['categoryID'=>83,'categoryName'=>'Fish Fillets, Crab Sticks & Others',			'parentCategoryID'=>'79'],
							['categoryID'=>84,'categoryName'=>'Prawns, Crabs & Other Seafood',				'parentCategoryID'=>'79'],
							['categoryID'=>85,'categoryName'=>'Beef',										'parentCategoryID'=>'80'],
							['categoryID'=>86,'categoryName'=>'Lamb',										'parentCategoryID'=>'80'],
							['categoryID'=>87,'categoryName'=>'Pork',										'parentCategoryID'=>'80'],
							['categoryID'=>88,'categoryName'=>'Poultry',									'parentCategoryID'=>'80'],
							['categoryID'=>89,'categoryName'=>'Sausages, Bacons & Burger Meat',				'parentCategoryID'=>'80'],
							['categoryID'=>90,'categoryName'=>'Beans & Peas',								'parentCategoryID'=>'81'],
							['categoryID'=>91,'categoryName'=>'Corn',										'parentCategoryID'=>'81'],
							['categoryID'=>92,'categoryName'=>'Fruits',										'parentCategoryID'=>'81'],
							['categoryID'=>93,'categoryName'=>'Potatoes',									'parentCategoryID'=>'81']
);
		
		for($i=0; $i<count($collection); $i++) {
			//for debug input data error
			//print_r(Arr::get($collection,$i));
			DB::table('item_category')->insert([Arr::get($collection,$i)]);
		}
    }
}
