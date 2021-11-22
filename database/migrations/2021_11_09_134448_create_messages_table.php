<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->text('body');
            $table->unsignedBigInteger('sender_id')->nullable();
            $table->unsignedBigInteger('sent_to_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('admin_sender_id')->nullable();
            $table->unsignedBigInteger('sender_status')->nullable();
            $table->unsignedBigInteger('receiver_status')->nullable();
            $table->unsignedBigInteger('status');
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
        Schema::dropIfExists('messages');
    }
}
