<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineRoomChildPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_room_child_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('price_id');
            $table->date('from_date')->comment('Start Date');
            $table->date('to_date')->comment('End Date');
            $table->integer('min_age');
            $table->integer('max_age');
            $table->integer('cwb_price');
            $table->integer('cnb_price');
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
            $table->foreign('price_id')->references('id')->on('offline_room_prices')->onDelete('cascade');
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
        Schema::dropIfExists('offline_room_child_prices');
    }
}
