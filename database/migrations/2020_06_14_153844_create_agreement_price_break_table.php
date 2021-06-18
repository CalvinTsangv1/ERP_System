<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementPriceBreakTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_price_break', function (Blueprint $table) {
            $table->integer('agreeID');
			$table->integer('revision');
			$table->unsignedInteger('itemID');
			$table->integer('priceBreak');
			$table->decimal('discount',3,2);
			
			$table->primary(['agreeID','revision','itemID','priceBreak']);	
			$table->foreign(['agreeID','revision','itemID'])->references(['agreementID','revision','itemID'])->on('agreement_line');
        });
		
		Schema::table('agreement_price_break', function (Blueprint $table) {
			$table->renameColumn('agreeID', 'agreementID');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('agreement_price_break');
    }
}
