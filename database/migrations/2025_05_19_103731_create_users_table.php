<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateUsersTable extends Migration
{
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('users');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('users', function (Blueprint $table) {
            $table->id();
                $table->string('username');
            $table->string('password');
            $table->string('full_name')->nullable();
            $table->string('email', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('address', 255)->nullable();
            $table->char('gender')->nullable();
            $table->string('avatar')->nullable();
            $table->tinyInteger('role')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
