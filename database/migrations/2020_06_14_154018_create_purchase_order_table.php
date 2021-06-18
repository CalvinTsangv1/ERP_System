<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_order', function (Blueprint $table) {
            $table->increments('poNo');
			$table->unsignedInteger('requestID');
			$table->integer('agreementID')->nullable()->default(NULL);
			$table->integer('revision')->nullable()->default(NULL);
			$table->integer('releaseNo')->nullable()->default(NULL);
			$table->unsignedInteger('supplierID');
			$table->string('type', 24);
			$table->string('status', 20);
			$table->string('quotationNo', 255)->nullable()->default(NULL); //random generate
			$table->date('createdDate');
			$table->integer('account');
			$table->string('shipmentAddress', 255);
			
			$table->foreign('supplierID')->references('supplierID')->on('supplier');
			$table->foreign('requestID')->references('requestID')->on('purchase_request');
			$table->foreign(['agreementID', 'revision'])->references(['agreementID','revision'])->on('agreement_header');	
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('purchase_order');
    }
}
