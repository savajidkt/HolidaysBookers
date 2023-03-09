<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('hotel_country');
            $table->unsignedBigInteger('hotel_state');
            $table->unsignedBigInteger('hotel_city');
            $table->unsignedBigInteger('hotel_group_id');
            $table->unsignedBigInteger('property_type_id');
            $table->unsignedBigInteger('hotel_type');
            $table->string('hotel_code')->nullable();
            $table->string('hotel_name');
            $table->string('category');
            $table->string('phone_number');
            $table->string('fax_number');
            $table->longText('hotel_address');
            $table->string('currency')->nullable();
            $table->string('hotel_image_location')->nullable();
            $table->longText('hotel_description')->nullable();
            $table->string('hotel_review')->nullable();
            $table->string('hotel_email')->nullable();
            $table->string('hotel_latitude')->nullable();
            $table->string('hotel_longitude')->nullable();
            $table->string('is_new')->nullable();
            $table->string('cancel_days')->nullable();
            $table->string('cancellation_policy')->nullable();
            $table->boolean('status')->default(true)->comment('1=Active, 0=Inactive');
           

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('hotel_country')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('hotel_state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('hotel_city')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('hotel_group_id')->references('id')->on('hotel_groups')->onDelete('cascade');
            $table->foreign('property_type_id')->references('id')->on('property_types')->onDelete('cascade');
            $table->foreign('hotel_type')->references('id')->on('apis')->onDelete('cascade');

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
        Schema::dropIfExists('hotels');
    }
}
