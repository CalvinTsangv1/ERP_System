<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementLineTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_line', function (Blueprint $table) {
            $table->integer('agreementID');
			$table->integer('revision');
			$table->unsignedInteger('itemID');
			$table->integer('promisedQuantity')->nullable()->default(NULL);
			$table->integer('balance')->nullable()->default(NULL);
			$table->integer('minimumOrderQuantity')->nullable()->default(NULL);
			$table->decimal('price', 10, 2);
			$table->string('reference', 255)->nullable()->default(NULL);

			$table->primary(['agreementID','revision','itemID']);	
			$table->foreign(['agreementID','revision'])->references(['agreementID','revision'])->on('agreement_header');
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
        //Schema::dropIfExists('agreement_line');
    }
}
