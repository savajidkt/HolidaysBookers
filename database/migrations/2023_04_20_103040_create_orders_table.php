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

            $table->unsignedBigInteger('hotel_country_id');
            $table->unsignedBigInteger('hotel_city_id');
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('hotel_id');

            $table->string('booking_id');
            $table->string('booking_code');
            $table->string('confirmation_no');
            $table->boolean('status')->default(1)->comment('1 = Processed, 2 = Confirmed, 3 = Cancelled, 4 = Vouchered');
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
            $table->boolean('type')->default(1)->comment('1 = Offline, 2 = API');
            $table->integer('total_rooms')->default(0);
            $table->integer('total_nights')->default(0);
            $table->double('rating', 10, 2)->default(0);
            $table->boolean('payment')->default(false)->comment('0 = No, 1 = Yes');
            $table->longText('comments')->nullable();
            $table->string('guest_lead')->nullable();
            $table->string('guest_phone')->nullable();
            $table->boolean('mail_sent')->default(false)->comment('0 = No, 1 = Yes');
            $table->boolean('booked_by')->default(2)->comment('1 = Agent, 2 = Customer, 3 = Vendor, 4 = Corporate');
            $table->longText('prebook_response')->nullable();
            $table->longText('booking_response')->nullable();
            $table->date('deadline_date')->comment('Deadline Date');
            $table->integer('agent_markup_type');
            $table->double('agent_markup_val', 10, 2)->default(0);            
            $table->string('id_proof_type')->default(false)->comment('0 = None, 1 = Aadhaar Card, 2 = Passport, 3 = Driving Licence, 4 = Voters ID Card, 5 = PAN Card, 6 = Other');
            $table->string('id_proof_no');
            $table->double('total_price_markup', 10, 2)->default(0);
            $table->boolean('is_pay_using')->default(false)->comment('1 = Online, 2 = Wallet');

            $table->foreign('package_id')->references('id')->on('packages')->onDelete('cascade');
            $table->foreign('hotel_id')->references('id')->on('hotels')->onDelete('cascade');
            $table->foreign('hotel_country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('hotel_city_id')->references('id')->on('cities')->onDelete('cascade');

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
