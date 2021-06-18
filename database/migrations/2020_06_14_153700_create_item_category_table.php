<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_category', function (Blueprint $table) {
			$table->increments('categoryID');
			$table->string('categoryName', 255);
			$table->unsignedInteger('parentCategoryID')->nullable()->default(NULL);
// 			You need to either (i) change your database schema to cascade delete to the child rows, or set them to null; or, (ii) delete the projects in the Laravel app first
			$table->foreign('parentCategoryID')->references('categoryID')->on('item_category');
// 		加＞	->onDelete('set null') / onDelete('cascade') 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('item_category');
    }
}
