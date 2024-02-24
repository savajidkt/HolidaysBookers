<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineroomssurchargeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_rooms_surcharge', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_id'); 
            $table->string('surcharge_name')->nullable();          
            $table->integer('surcharge_price')->default(0);            
            $table->date('surcharge_date_start')->nullable();
            $table->date('surcharge_date_end')->nullable();
            $table->enum('apply_for',["0","1"])->default(0)->comment('0: Apply Room, 1 Apply Hotel');
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
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
        Schema::dropIfExists('offline_rooms_surcharge');
    }
}
