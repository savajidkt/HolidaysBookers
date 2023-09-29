<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuoteMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quote_masters', function (Blueprint $table) {
            $table->id();
            $table->double('original_amount', 10, 2)->default(0);
            $table->string('original_currency');
            $table->double('booking_amount', 10, 2)->default(0);
            $table->string('booking_currency');
            $table->double('tax', 10, 2)->default(0);
            $table->double('tax_amount', 10, 2)->default(0);
            $table->integer('agent_markup_type');
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
            $table->longText('comments')->nullable();
            $table->boolean('passenger_type')->default(false)->comment('0 = Lead, 1 = All');
            $table->string('lead_passenger_name')->nullable();
            $table->string('lead_passenger_id_proof')->nullable();
            $table->string('lead_passenger_id_proof_no')->nullable();
            $table->integer('lead_passenger_phone_code')->default(0);
            $table->string('lead_passenger_phone')->nullable();

            // $table->boolean('extra_margin_type')->default(1)->comment('1 = Percentage Margin, 2 = Fix Margin');
            // $table->double('extra_margin_amt', 10, 2)->default(0);
            // $table->string('extra_quote_email')->nullable();

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
        Schema::dropIfExists('quote_masters');
    }
}
