<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderPaxInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_pax_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->longText('pax_info_data_serialize');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
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
        Schema::dropIfExists('order_pax_infos');
    }
}
