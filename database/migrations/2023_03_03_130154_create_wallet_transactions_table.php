<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('agent_id');
            $table->string('transaction_type')->nullable();
            $table->string('pnr')->nullable();            
            $table->double('amount',10,2)->default(0);
            $table->boolean('type')->default(false)->comment('1=Credit, 0=Debit');
            $table->text('comment')->nullable();
            $table->double('balance',10,2)->default(0);
            $table->timestamps();
            
            //FOREIGN KEY CONSTRAINTS
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet_transactions');
    }
}
