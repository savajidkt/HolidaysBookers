<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempBookingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('temp_bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('price_id');
            $table->string('adult');
            $table->string('child')->nullable();
            $table->string('room');
            $table->string('city_id');
            $table->string('search_from');
            $table->string('search_to');            
            $table->string('gst_enable')->default(false)->comment('0 = No 1 = Yes Card');
            $table->string('registration_number')->nullable();
            $table->string('registered_company_name')->nullable();
            $table->string('registered_company_address')->nullable();
            $table->string('coupon_code')->nullable();   
            $table->double('coupon_amount', 10, 2)->default(0);         
            $table->double('tax', 10, 2)->default(0);            
            $table->double('total_amount', 10, 2)->default(0);
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
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
        Schema::dropIfExists('temp_bookings');
    }
}
