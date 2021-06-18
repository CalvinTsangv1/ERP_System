<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryNoteItemTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_note_item', function (Blueprint $table) {
            $table->unsignedInteger('dnNo');
			$table->unsignedInteger('itemID');
			$table->integer('quantity');
			
			$table->primary(['dnNo', 'itemID']);
			$table->foreign('dnNo')->references('dnNo')->on('delivery_note');
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
        //Schema::dropIfExists('delivery_note_item');
    }
}
