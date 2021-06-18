<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request_item', function (Blueprint $table) {
            $table->unsignedInteger('requestID');
			$table->unsignedInteger('itemID');
			$table->integer('quantity');
			$table->integer('balance');
			
			$table->foreign('requestID')->references('requestID')->on('purchase_request');
			$table->foreign('itemID')->references('itemID')->on('item');
			$table->primary(['requestID','itemID']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('purchase_request_item');
    }
}
