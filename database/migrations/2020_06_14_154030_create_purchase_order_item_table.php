2<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order_item', function (Blueprint $table) {
            $table->unsignedInteger('poNo');
			$table->unsignedInteger('itemID');
			$table->integer('quantity');
			$table->decimal('amount', 10, 2);
			$table->integer('balance');
			
			$table->primary(['poNo','itemID']);
			$table->foreign('poNo')->references('poNo')->on('purchase_order');
            $table->foreign('itemID')->references('itemID')->on('item');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('purchase_order_item');
    }
}
