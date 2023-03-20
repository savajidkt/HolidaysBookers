<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineroomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('room_type_id');
           // $table->unsignedBigInteger('amenities_id');
            $table->integer('total_adult')->default(0);
            $table->integer('total_cwb')->default(0);
            $table->integer('total_cnb')->default(0);
            $table->integer('max_pax')->default(0);
            $table->integer('min_pax')->default(0);
            $table->string('room_inclusion')->nullable();
            $table->string('allotment')->nullable();
            $table->string('cancel_policy')->nullable();
            $table->string('accommodation_policy')->nullable();
            $table->boolean('type')->default(1)->comment('1=Offline, 2=API');
            $table->string('api_name')->nullable();
            $table->text('room_image')->nullable();
            $table->boolean('status')->default(false)->comment('1=Active, 0=Inactive');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');            
            $table->foreign('room_type_id')->references('id')->on('room_types')->onDelete('cascade');
            //$table->foreign('amenities_id')->references('id')->on('amenities')->onDelete('cascade');
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
        Schema::dropIfExists('offlinerooms');
    }
}
