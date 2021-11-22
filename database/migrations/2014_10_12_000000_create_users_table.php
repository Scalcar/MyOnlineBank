<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('id');
            $table->string('fname');
            $table->string('lname');
            $table->integer('gender');
            $table->date('dob');
            $table->char('cnp',13)->unique();
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('address');
            $table->string('username');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('admin_id');           
            $table->rememberToken();
            $table->string('profile_picture')->nullable()->default(null);
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
        Schema::dropIfExists('users');
    }
}
