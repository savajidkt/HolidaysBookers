<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_country');
            $table->unsignedBigInteger('agent_state');
            $table->unsignedBigInteger('agent_city');
            $table->unsignedBigInteger('agent_know_about')->nullable();
            $table->string('agent_code')->nullable();
            $table->string('agent_company_name')->nullable();
            $table->string('agent_company_type')->nullable();
            $table->string('nature_of_business')->nullable();
            $table->string('agent_first_name')->nullable();
            $table->string('agent_last_name')->nullable();
            $table->string('agent_designation')->nullable();
            $table->date('agent_dob')->nullable();
            $table->string('agent_office_address')->nullable();
            $table->string('agent_pincode')->nullable();
            $table->string('agent_telephone')->nullable();
            $table->string('agent_mobile_number')->nullable();
            $table->string('agent_email')->nullable();
            $table->string('agent_website')->nullable();
            $table->string('agent_iata')->nullable();
            $table->string('agent_iata_number')->nullable();
            $table->string('agent_other_certification')->nullable();
            $table->string('agent_pan_number')->nullable();
            $table->string('agent_gst_number')->nullable();
            $table->string('mgmt_first_name')->nullable();
            $table->string('mgmt_last_name')->nullable();
            $table->string('mgmt_contact_number')->nullable();
            $table->string('mgmt_email')->nullable();
            $table->string('account_first_name')->nullable();
            $table->string('account_last_name')->nullable();
            $table->string('account_contact_number')->nullable();
            $table->string('account_email')->nullable();
            $table->string('reserve_first_name')->nullable();
            $table->string('reserve_last_name')->nullable();
            $table->string('reserve_contact_number')->nullable();
            $table->string('reserve_email')->nullable();
            $table->string('agent_pan_card')->nullable();
            $table->string('agent_company_certificate')->nullable();
            $table->string('agent_company_logo')->nullable();
            
            $table->string('othername')->nullable();

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agent_country')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('agent_state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('agent_city')->references('id')->on('cities')->onDelete('cascade');
            $table->foreign('agent_know_about')->references('id')->on('reachus')->onDelete('cascade');
            

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
        Schema::dropIfExists('agents');
    }
}
