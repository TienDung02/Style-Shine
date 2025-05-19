<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('customers');
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('password');
            $table->string('cus_name')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone_number', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->char('sex')->nullable();
            $table->string('otp')->nullable();
            $table->string('avatar_url')->nullable();
            $table->string('dob')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
