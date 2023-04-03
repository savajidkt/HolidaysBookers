<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRezliveHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rezlive_hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_country');
            $table->unsignedBigInteger('hotel_city');

            $table->string('hotel_code')->nullable();
            $table->string('hotel_name')->nullable();
            $table->string('hotel_review')->nullable();
            $table->longText('hotel_address')->nullable();
            $table->string('CityId')->nullable();
            $table->string('CountryId')->nullable();
            $table->foreign('hotel_country')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('hotel_city')->references('id')->on('cities')->onDelete('cascade');
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
        Schema::dropIfExists('rezlive_hotels');
    }
}
