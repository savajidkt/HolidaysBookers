<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineRoomPricesCancelationPoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_room_prices_cancelation_policies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('price_id');
            $table->integer('before_check_in_days')->nullable();            
            $table->integer('night')->default(0);
            $table->integer('night_charge')->nullable();
            $table->text('description')->nullable();            
            //FOREIGN KEY CONSTRAINTS
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
        Schema::dropIfExists('offline_room_prices_cancelation_policies');
    }
}
