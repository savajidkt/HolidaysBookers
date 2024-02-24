<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplimentariesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complimentaries', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_id');            
            $table->unsignedBigInteger('mealplans_id');                                           
            $table->double('complimentary_price', 10, 2)->default(0);
            $table->enum('apply_for',["0","1"])->default(0)->comment('0: Apply Room, 1 Apply Hotel');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
            $table->foreign('mealplans_id')->references('id')->on('mealplans')->onDelete('cascade');
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
        Schema::dropIfExists('complimentaries');
    }
}
