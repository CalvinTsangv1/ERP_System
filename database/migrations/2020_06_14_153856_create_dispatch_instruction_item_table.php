<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDispatchInstructionItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dispatch_instruction_item', function (Blueprint $table) {
            $table->unsignedInteger('diNo');
			$table->unsignedInteger('itemID');
			$table->integer('quantity');
			$table->integer('balance');
			
			$table->primary(['diNo','itemID']);
			$table->foreign('diNo')->references('diNo')->on('dispatch_instruction');
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
        //Schema::dropIfExists('dispatch_instruction_item');
    }
}
