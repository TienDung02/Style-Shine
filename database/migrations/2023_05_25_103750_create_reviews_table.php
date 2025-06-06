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
    public function up(): void
    {

//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('reviews');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('reviews', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->float('rating');
            $table->text('comment');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
