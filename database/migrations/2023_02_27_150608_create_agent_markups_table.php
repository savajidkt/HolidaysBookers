<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentMarkupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_markups', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->integer('rezlive')->default(0);
            $table->integer('offline_hotel')->default(0);
            $table->integer('sightseeing')->default(0);
            $table->integer('transfer')->default(0);
            $table->integer('package')->default(0);
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
        Schema::dropIfExists('agent_markups');
    }
}
