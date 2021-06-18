<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_note', function (Blueprint $table) {
            $table->increments('dnNo');
			$table->unsignedInteger('diNo');
			$table->date('createdDate');
			$table->string('status', 20);
			
			$table->foreign('diNo')->references('diNo')->on('dispatch_instruction');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('delivery_note');
    }
}
