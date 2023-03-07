<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');                        
            $table->date('dob')->comment('Date Of Birth');
            $table->unsignedBigInteger('country');
            $table->unsignedBigInteger('state');
            $table->unsignedBigInteger('city');
            $table->string('zipcode');
            $table->string('telephone')->nullable();
            $table->string('mobile_number');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('city')->references('id')->on('cities')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
