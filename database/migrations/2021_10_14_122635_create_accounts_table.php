<?php

use App\General\Concretes\Enums\PinStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->string('accNo')->unique();
            $table->integer('branch');
            $table->integer('type');
            $table->decimal('balance',14,3);
            $table->integer('currency');
            $table->char('pin',4);
            $table->integer('pinStatus')->default(PinStatus::UNSAFE_STATUS_ID);          
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('admin_id');
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
        Schema::dropIfExists('accounts');
    }
}
