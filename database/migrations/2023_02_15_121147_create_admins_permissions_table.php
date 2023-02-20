<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsPermissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('permission_id');

            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('admin')->onDelete('cascade');
            $table->foreign('permission_id')->references('id')->on('permissions')->onDelete('cascade');

            //SETTING THE PRIMARY KEYS
           // $table->primary(['user_id','permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins_permissions');
    }
}
