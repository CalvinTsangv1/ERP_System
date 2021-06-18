<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBranchItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('branch_item', function (Blueprint $table) {
            $table->unsignedInteger('branchID');
			$table->unsignedInteger('itemID');
			$table->integer('quantity');
			$table->integer('lowStockLevel')->nullable()->default(NULL); // for notification
            
			$table->primary(['branchID','itemID']);
			$table->foreign('branchID')->references('branchID')->on('branch');
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
        //Schema::dropIfExists('branch_item');
    }
}
