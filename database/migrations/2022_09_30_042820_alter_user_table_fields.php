<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUserTableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('first_name')->after('name')->nullable();
            $table->string('last_name')->after('first_name')->nullable();
            $table->tinyInteger('user_type')->after('password')->default(2)->comment('1=Agent, 2=Customer');
            $table->tinyInteger('status')->after('user_type')->default(0)->comment('0=Inactive, 1=Active');
            $table->dropColumn('name');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('first_name');
            $table->dropColumn('last_name');
            $table->dropColumn('user_type');
            $table->dropColumn('status');
            $table->string('name')->after('id');
            $table->dropColumn('deleted_at');
        });
    }
}
