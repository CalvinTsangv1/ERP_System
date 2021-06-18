<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchInstructionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_instruction', function (Blueprint $table) {
            $table->increments('diNo');
			$table->unsignedInteger('requestID');
			$table->date('createdDate');
			$table->string('status', 10);
			
			$table->foreign('requestID')->references('requestID')->on('purchase_request');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('dispatch_instruction');
    }
}
