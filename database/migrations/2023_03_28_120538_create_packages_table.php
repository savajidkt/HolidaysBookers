<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();

            $table->unsignedBigInteger('hotel_name_id');
            $table->unsignedBigInteger('room_type_id');
            $table->unsignedBigInteger('meal_plan_id');
            $table->unsignedBigInteger('currency_id');
            $table->string('package_name');
            $table->string('package_code');
            $table->date('valid_from')->comment('Package Validity Start Date');
            $table->date('valid_till')->comment('Package Validity End Date');
            $table->integer('nationality');
            $table->date('travel_valid_from')->comment('Package Travel Validity Start Date')->nullable();
            $table->date('travel_valid_till')->comment('Package Travel Validity End Date')->nullable();
            $table->integer('cutoff_price')->default(0);
            $table->integer('duration')->default(0);
            $table->date('sold_out_from')->comment('Package Sold out dates Validity Start Date')->nullable();
            $table->date('sold_out_till')->comment('Package Sold out dates Validity End Date')->nullable();
            $table->integer('sleepsmax')->default(0);
            $table->integer('maxadults')->default(0);
            $table->integer('maxchildwmaxadults')->default(0);
            $table->integer('maxchildwoextrabed')->default(0);
            $table->integer('mincwbage')->default(0);
            $table->integer('mincwobage')->default(0);
            $table->integer('marketprice')->default(0);
            $table->string('rate_offered')->default(0)->nullable();
            $table->integer('commission')->default(0)->nullable();
            $table->integer('singleadult')->default(0);
            $table->integer('twinsharing')->default(0);
            $table->integer('extraadult')->default(0);
            $table->integer('cwb')->default(0);
            $table->integer('cob')->default(0);
            $table->integer('ccob')->default(0);
            $table->integer('singleadulttax')->default(0);
            $table->integer('twinsharingtax')->default(0);
            $table->integer('extraadulttax')->default(0);
            $table->integer('cwbtax')->default(0);
            $table->integer('cobtax')->default(0);
            $table->integer('ccobtax')->default(0);
            // $table->integer('rate_per_adult');
            // $table->integer('rate_per_child_cwb');
            // $table->integer('rate_per_child_cnb');
            // $table->integer('rate_per_infant');
            // $table->integer('minimum_pax');
            // $table->integer('maximum_pax');
            $table->integer('cancel_day');
            $table->string('terms_and_conditions_pdf')->nullable();
            $table->boolean('status')->default(false)->comment('1=Active, 0=Inactive');
            $table->text('highlights');
            $table->text('terms_and_conditions');
            $table->boolean('type')->default(false)->comment('0=Admin, 1=Vendor');            
            $table->foreign('hotel_name_id')->references('id')->on('hotels');
            $table->foreign('room_type_id')->references('id')->on('room_types');
            $table->foreign('meal_plan_id')->references('id')->on('mealplans');
            $table->foreign('currency_id')->references('id')->on('currencies');
            $table->foreign('user_id')->references('id')->on('users')->nullable();
            $table->foreign('vendor_id')->references('id')->on('vendors')->nullable();

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
        Schema::dropIfExists('packages');
    }
}
