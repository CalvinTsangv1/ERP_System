<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            // $table->id();
            // $table->timestamps();
            // Create auto increment integer primary key 
            $table->bigIncrements('orderid'); 
            // Create a string column for vehicle registration number
            $table->string('regno', 10); 
            // Create a 3 characters column for vehicle registration state 
            $table->char('regstate', 3); 
            // Create a string column for customer name 
            $table->string('custname', 255); 
            // Create a integer column for customer phone 
            $table->integer('custphone'); 
            // Create a string column for vehicle brand 
            $table->string('vehbrand', 255); 
            // Create a string column for vehicle model 
            $table->string('vehmodel', 255); 
            // Create a integer column for vehicle manufactured year 
            $table->integer('vehyear'); 
            // Create a nullable double for the order total cost
            $table->double('totalcost', 10, 2)->nullable(); 
            // Create a nullable double for the order total amount
            $table->double('totalamount', 10, 2)->nullable();
            // Create a nullable datetime column for order created date 
            $table->dateTime('createddate', 0)->nullable(); 
            // Create a nullable datetime column for order finalized date 
            $table->dateTime('finalizeddate', 0)->nullable(); 
            // Create a integer column for order status 
            $table->integer('orderstatus')->default(0); 
            // Create a integer column for vehicle odo meter 
            $table->integer('odometer')->nullable(); 
            // Create a string column for vehicle serial no. 
            $table->string('serialno', 255); 

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('orders');
    }
}
