<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromotionalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotionals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');   
            $table->unsignedBigInteger('room_id');         
            $table->double('single_adult', 10, 2)->default(0);        
            $table->double('per_room', 10, 2)->default(0);        
            $table->double('extra_adult', 10, 2)->default(0);        
            $table->double('child_with_bed', 10, 2)->default(0);        
            $table->double('child_with_no_bed_0_4', 10, 2)->default(0);        
            $table->double('child_with_no_bed_5_12', 10, 2)->default(0);        
            $table->double('child_with_no_bed_13_18', 10, 2)->default(0);        
            $table->date('date_validity_start')->nullable();
            $table->date('date_validity_end')->nullable();            
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
        Schema::dropIfExists('promotionals');
    }
}
