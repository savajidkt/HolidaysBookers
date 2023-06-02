<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('adult_id')->nullable();
            $table->unsignedBigInteger('child_id')->nullable();
            $table->integer('room_id')->nullable();
            $table->integer('price_id')->nullable();
            $table->string('type')->default(false)->comment('0 = Adult', '1 = Child');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('adult_id')->references('id')->on('order_adult')->onDelete('cascade');
            $table->foreign('child_id')->references('id')->on('order_childs')->onDelete('cascade');
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
        Schema::dropIfExists('order_rooms');
    }
}
