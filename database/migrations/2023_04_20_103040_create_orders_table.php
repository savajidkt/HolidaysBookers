<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('hotel_id');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('room_id');
            $table->string('confirmation_no');
            $table->string('booking_id');
            $table->boolean('voucher')->default(false)->comment('1=Yes, 0=No');
            $table->double('original_amount', 10, 2)->default(0);
            $table->string('original_currency');
            $table->double('booking_amount', 10, 2)->default(0);
            $table->string('booking_currency');
            $table->string('agent_code');
            $table->string('agent_email');
            $table->string('hotel_name');
            $table->date('check_in_date')->comment('Check-in Date');
            $table->date('check_out_date')->comment('Check-out Date');
            $table->date('cancelled_date')->comment('Cancelled Date');
            $table->boolean('type')->default(false)->comment('0 = Offline, 1 = API');
            $table->integer('total_rooms')->default(0);
            $table->integer('total_nights')->default(0);
            $table->double('rating', 10, 2)->default(0);
            $table->longText('adult_child_details');
            $table->longText('child_age_details')->nullable();
            $table->longText('child_bad_details')->nullable();
            $table->longText('comments')->nullable();
            $table->longText('cancel_policy')->nullable();
            $table->string('guest_lead')->nullable();
            $table->string('guest_phone')->nullable();
            $table->longText('pax_info')->nullable();
            $table->string('reference_id')->nullable();
            $table->integer('agent_markup_type');            
            $table->double('agent_markup_val', 10, 2)->default(0);
            $table->string('id_proof_type')->nullable();
            $table->string('id_proof_no')->nullable();
            $table->double('total_price_markup', 10, 2)->default(0);
            $table->boolean('booked_by')->default(2)->comment('1 = Agent, 2 = Customer, 3 = Vendor, 4 = Corporate');
            $table->boolean('mail_sent')->default(false)->comment('0 = No, 1 = Yes');
            $table->boolean('payment')->default(false)->comment('0 = No, 1 = Yes');
            $table->boolean('status')->default(false)->comment('0 = Processed, 1 = Confirmed, 2 = Cancelled');
            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('offline_rooms')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
