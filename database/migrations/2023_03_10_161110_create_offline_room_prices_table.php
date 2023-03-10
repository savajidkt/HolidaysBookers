<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineRoomPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_room_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->date('from_date')->comment('Start Date');
            $table->date('to_date')->comment('End Date');
            $table->double('single_adult_price', 10, 2);
            $table->double('adult_price', 10, 2);
            $table->double('extra_bed_price', 10, 2);
            $table->integer('price_type');
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
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
        Schema::dropIfExists('offline_room_prices');
    }
}
