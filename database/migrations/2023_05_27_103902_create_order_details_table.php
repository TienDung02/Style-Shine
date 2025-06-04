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
        Schema::dropIfExists('order_details');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        Schema::create('order_details', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_detail');
    }
};
