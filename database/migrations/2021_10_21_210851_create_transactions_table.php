<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('trans_no')->unique();          
            $table->string('description');
            $table->decimal('credit',14,3)->nullable()->default('0');
            $table->decimal('debit',14,3)->nullable()->default('0');
            $table->decimal('balance',14,3);
            $table->unsignedBigInteger('account_id');
            $table->unsignedBigInteger('contact_id')->nullable()->default(null);
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
        Schema::dropIfExists('transactions');
    }
}
