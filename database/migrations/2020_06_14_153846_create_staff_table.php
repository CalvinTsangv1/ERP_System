<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->increments('staffID');
			$table->unsignedInteger('branchID');
			$table->string('name', 255);
			$table->string('postTitle', 255);
			$table->string('password', 255);
			
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
        //Schema::dropIfExists('staff');
    }
}


// Not Used.
// To be dropped.