<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReachusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reachus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('show_other_textbox')->default(false)->comment('1=Yes, 0=No');
            $table->string('textbox_lable');
            $table->boolean('status')->default(false)->comment('1=Active, 0=Inactive');
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
        Schema::dropIfExists('reachus');
    }
}
