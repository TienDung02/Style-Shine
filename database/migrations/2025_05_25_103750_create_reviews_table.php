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
    public function up(): void
    {

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('reviews');
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->float('rating');
            $table->text('comment');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
