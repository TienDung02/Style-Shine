<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
return new class extends Migration
{
    /**
     * Run the migrations.
     *
     */
    protected $engine = 'InnoDB';
    public function up(): void
    {

//        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Schema::dropIfExists('product_images');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('product_images', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->longText('image_url');
            $table->boolean('is_primary')->default(false);
            $table->integer('product_id');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
