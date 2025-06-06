<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     */
    protected $engine = 'InnoDB';
    public function up()
    {

//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('orders');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('orders', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->decimal('total_price', 10, 2);
            $table->string('payment_method');
            $table->string('status');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('payment_date');
            $table->timestamps();
            $table->softDeletes();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
