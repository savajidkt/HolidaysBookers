<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddColumnMealPlanOfflineRooms extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('offline_rooms', function (Blueprint $table) {            
            $table->unsignedBigInteger('meal_plan_id')->after('room_type_id')->nullable();
            $table->foreign('meal_plan_id')->references('id')->on('mealplans')->onDelete('cascade'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('offline_rooms', function (Blueprint $table) {
                
        });
    }
}
