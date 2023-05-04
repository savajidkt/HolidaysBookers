<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfflineRoomPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offline_room_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('room_id');
            $table->unsignedBigInteger('meal_plan_id');
            $table->unsignedBigInteger('currency_id');
            $table->date('from_date')->comment('Start Date');
            $table->date('to_date')->comment('End Date');
            $table->date('booking_start_date')->nullable();
            $table->date('booking_end_date')->nullable();
            $table->integer('cutoff_price')->default(0);
            $table->integer('min_nights')->default(0);
            $table->integer('min_overall_nights')->default(0);
            $table->integer('price_p_n_single_adult')->default(0);
            $table->integer('price_p_n_twin_sharing')->default(0);
            $table->integer('price_p_n_extra_adult')->default(0);
            $table->integer('price_p_n_cwb')->default(0);
            $table->integer('price_p_n_cob')->default(0);
            $table->integer('price_p_n_ccob')->default(0);
            $table->integer('tax_p_n_single_adult')->default(0)->nullable();
            $table->integer('tax_p_n_twin_sharing')->default(0)->nullable();
            $table->integer('tax_p_n_extra_adult')->default(0)->nullable();
            $table->integer('tax_p_n_cwb')->default(0)->nullable();
            $table->integer('tax_p_n_cob')->default(0)->nullable();
            $table->integer('tax_p_n_ccob')->default(0)->nullable();
            $table->integer('market_price')->default(0)->nullable();
            $table->string('promo_code')->nullable();
            $table->string('rate_offered')->default(0)->nullable();            
            $table->integer('commission')->default(0)->nullable();   
            $table->string('cancelation_policy')->nullable();         
            $table->integer('days_monday')->default(0)->nullable();
            $table->integer('days_tuesday')->default(0)->nullable();
            $table->integer('days_wednesday')->default(0)->nullable();
            $table->integer('days_thursday')->default(0)->nullable();
            $table->integer('days_friday')->default(0)->nullable();
            $table->integer('days_saturday')->default(0)->nullable();
            $table->integer('days_sunday')->default(0)->nullable();
            $table->integer('price_type');
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
            $table->foreign('currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('meal_plan_id')->references('id')->on('mealplans')->onDelete('cascade');
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
        Schema::dropIfExists('offline_room_prices');
    }
}
