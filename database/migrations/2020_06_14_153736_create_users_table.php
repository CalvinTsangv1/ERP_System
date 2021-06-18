<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->unique();
            $table->unsignedInteger('branchID');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password', 255);
            $table->string('postTitle', 20)->default('Restaurant Manager');
            $table->rememberToken();
            $table->timestamps();
            
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
        //Schema::dropIfExists('users');
    }
}
