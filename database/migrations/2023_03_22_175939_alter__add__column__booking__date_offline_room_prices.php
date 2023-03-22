<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnBookingDateOfflineRoomPrices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_room_prices', function (Blueprint $table) {
            $table->date('booking_start_date')->after('to_date')->nullable();                   
            $table->date('booking_end_date')->after('booking_start_date')->nullable();                   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_room_prices', function (Blueprint $table) {
            //
        });
    }
}
