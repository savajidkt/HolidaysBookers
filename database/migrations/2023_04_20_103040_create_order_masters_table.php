<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_masters', function (Blueprint $table) {
            $table->id();
            $table->string('prn_number');
            $table->string('booking_id');
            $table->string('booking_code');
            $table->string('invoice_no');
            $table->string('confirmation_no');
            $table->boolean('voucher')->default(false)->comment('1=Yes, 0=No');
            $table->double('order_amount', 10, 2)->default(0);
            $table->string('order_currency');
            $table->double('booking_amount', 10, 2)->default(0);
            $table->string('booking_currency');
            $table->double('tax', 10, 2)->default(0);
            $table->double('tax_amount', 10, 2)->default(0);
            $table->integer('agent_markup_type')->comment('1: Percentage, 2: Fix');
            $table->double('agent_markup_val', 10, 2)->default(0);
            $table->double('total_price_markup', 10, 2)->default(0);
            $table->string('agent_code');
            $table->string('agent_email');
            $table->integer('total_adult')->default(0);
            $table->integer('total_child')->default(0);
            $table->integer('total_child_with_bed')->default(0);
            $table->integer('total_child_without_bed')->default(0);
            $table->integer('total_rooms')->default(0);
            $table->integer('total_nights')->default(0);
            $table->boolean('payment_status')->default(false)->comment('0 = No, 1 = Yes');
            $table->longText('comments')->nullable();
            $table->boolean('mail_sent')->default(false)->comment('0 = No, 1 = Yes');
            $table->boolean('booked_by')->default(2)->comment('1 = Agent, 2 = Customer, 3 = Vendor, 4 = Corporate');
            $table->longText('prebook_response')->nullable();
            $table->longText('booking_response')->nullable();
            $table->longText('razorpay_responce')->nullable();
            $table->boolean('is_pay_using')->default(false)->comment('1 = Online, 2 = Wallet');
            $table->boolean('passenger_type')->default(false)->comment('0 = Lead, 1 = All');
            $table->string('lead_passenger_name')->nullable();
            $table->string('lead_passenger_id_proof')->nullable();
            $table->string('lead_passenger_id_proof_no')->nullable();
            $table->string('lead_passenger_phone')->nullable();
            $table->boolean('order_type')->default(false)->comment('0 = Draft, 1 = Order');
            $table->boolean('status')->default(1)->comment('1 = Processed, 2 = Confirmed, 3 = Cancelled, 4 = Vouchered');           
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
        Schema::dropIfExists('order_masters');
    }
}
