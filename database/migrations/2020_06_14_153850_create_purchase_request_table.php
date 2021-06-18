<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseRequestTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_request', function (Blueprint $table) {
            $table->increments('requestID');
			$table->unsignedInteger('branchID');
			$table->date('createdDate');
			$table->date('expectedDeliveryDate');
			$table->string('status', 20);
			$table->string('remarks', 255)->nullable()->default(NULL);
			
			$table->foreign('branchID')->references('branchID')->on('branch');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('purchase_request');
    }
}
