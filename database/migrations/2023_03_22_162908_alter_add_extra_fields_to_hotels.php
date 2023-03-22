<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterAddExtraFieldsToHotels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('hotels', function (Blueprint $table) {
            //
            $table->string('front_office_first_name')->after('cancel_days')->nullable();
            $table->string('front_office_designation')->after('front_office_first_name')->nullable();
            $table->string('front_office_contact_number')->after('front_office_designation')->nullable();
            $table->string('front_office_email')->after('front_office_contact_number')->nullable();

            $table->string('sales_first_name')->after('front_office_email')->nullable();
            $table->string('sales_designation')->after('sales_first_name')->nullable();
            $table->string('sales_contact_number')->after('sales_designation')->nullable();
            $table->string('sales_email')->after('sales_contact_number')->nullable();

            $table->string('reservation_first_name')->after('sales_email')->nullable();
            $table->string('reservation_designation')->after('reservation_first_name')->nullable();
            $table->string('reservation_contact_number')->after('reservation_designation')->nullable();
            $table->string('reservation_email')->after('reservation_contact_number')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('hotels', function (Blueprint $table) {
            //
        });
    }
}
