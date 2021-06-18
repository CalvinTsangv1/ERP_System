<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->increments('itemID');
			$table->string('virtualItemID', 255);
			$table->unsignedInteger('categoryID');
			$table->string('name', 255);
			$table->string('unitOfMeasurement', 255);
			$table->string('description', 255)->nullable()->default(NULL);
			
			$table->foreign('categoryID')->references('categoryID')->on('item_category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('item');
    }
}
