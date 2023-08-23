<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderHotelRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_hotel_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('order_hotel_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('room_price_id');           
            $table->string('room_name');
            $table->date('check_in_date')->comment('Check-in Date');
            $table->date('check_out_date')->comment('Check-out Date');            
            $table->double('origin_amount', 10, 2)->default(0);
            $table->double('product_markup_amount', 10, 2)->default(0);
            $table->double('agent_markup_amount', 10, 2)->default(0);
            $table->double('agent_global_markup_amount', 10, 2)->default(0);
            $table->double('price', 10, 2)->default(0);
            $table->integer('adult')->default(0);
            $table->integer('child')->default(0);
            $table->integer('child_with_bed')->default(0);
            $table->integer('child_without_bed')->default(0);

            $table->foreign('order_id')->references('id')->on('order_masters')->onDelete('cascade');
            $table->foreign('order_hotel_id')->references('id')->on('order_hotels')->onDelete('cascade');
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
        Schema::dropIfExists('order_hotel_rooms');
    }
}
