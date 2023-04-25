<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderChildTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_childs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');

            $table->string('child_first_name');
            $table->string('child_last_name');

            $table->string('id_proof_type')->default(false)->comment('0 = None', '1 = Aadhaar Card', '2 = Passport', '6 = Other');
            $table->string('child_id_proof_no')->nullable();
            $table->double('child_age', 10, 2)->default(0);

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
        Schema::dropIfExists('order_childs');
    }
}
