<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPassengersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_passengers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_hotel_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('order_hotel_room_id');
            $table->unsignedBigInteger('room_id');           
            $table->unsignedBigInteger('room_price_id');             
            $table->string('name')->nullable();
            $table->string('id_proof')->nullable();
            $table->string('id_proof_no')->nullable();
            $table->string('phone')->nullable();
            $table->boolean('is_adult')->default(false)->comment('0 = Yes, 1 = No');
            $table->integer('child_age')->default(0);
            $table->boolean('child_with_bed')->default(false)->comment('0 = No, 1 = Yes');

            $table->foreign('order_id')->references('id')->on('order_masters')->onDelete('cascade');
            $table->foreign('order_hotel_id')->references('id')->on('order_hotels')->onDelete('cascade');
            $table->foreign('order_hotel_room_id')->references('id')->on('order_hotel_rooms')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
            $table->foreign('room_price_id')->references('id')->on('offline_room_prices')->onDelete('cascade');

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
        Schema::dropIfExists('order_passengers');
    }
}
