<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderAdultTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_adult', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');

            $table->string('first_name');
            $table->string('last_name');

            $table->string('id_proof_type')->default(false)->comment('0 = None', '1 = Aadhaar Card', '2 = Passport', '3 = Driving Licence', '4 = Voters ID Card', '5 = PAN card', '6 = Other');
            $table->string('id_proof_no');

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
        Schema::dropIfExists('order_adult');
    }
}
