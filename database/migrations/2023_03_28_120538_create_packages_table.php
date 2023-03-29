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
            $table->string('package_name');
            $table->string('package_code');
            $table->date('valid_from')->comment('Package Validity Start Date');
            $table->date('valid_till')->comment('Package Validity End Date');
            $table->integer('nationality');
            $table->integer('rate_per_adult');
            $table->integer('rate_per_child_cwb');
            $table->integer('rate_per_child_cnb');
            $table->integer('rate_per_infant');
            $table->integer('minimum_pax');
            $table->integer('maximum_pax');
            $table->integer('cancel_day');
            $table->string('terms_and_conditions_pdf')->nullable();
            $table->boolean('status')->default(false)->comment('1=Active, 0=Inactive');
            $table->text('highlights');
            $table->text('terms_and_conditions');
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
