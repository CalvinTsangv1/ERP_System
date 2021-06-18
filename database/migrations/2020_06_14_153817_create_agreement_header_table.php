<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgreementHeaderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agreement_header', function (Blueprint $table) {
			$table->integer('agreementID');
			$table->integer('revision');
            $table->primary(['agreementID','revision']);
			$table->unsignedInteger('supplierID');
			$table->string('type', 27);
			$table->date('createdDate');
			$table->date('effectiveDate');
			$table->date('expiryDate');
			$table->string('status', 10);
			$table->decimal('amountAgreed',10,2)->nullable()->default(NULL);
			$table->string('currency', 3);
			$table->string('termsAndCondition', 255);
			$table->string('tentativeSchedule', 11)->nullable()->default(NULL);
			$table->string('deliveryAddress', 255);
			$table->foreign('supplierID')->references('supplierID')->on('supplier');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('agreement_header');
    }
}
