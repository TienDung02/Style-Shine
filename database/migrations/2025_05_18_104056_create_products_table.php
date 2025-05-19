<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('products');
        Schema::create('products', function (Blueprint $table) {
            $table->id('id_product');
            $table->string('name_product');
            $table->decimal('price', 8, 2);
            $table->string('quality')->nullable();
            $table->text('description')->nullable();
            $table->text('image_url')->nullable();
            $table->unsignedBigInteger('id_category');
            $table->foreign('id_category')->references('id_category')->on('categories')->onDelete('cascade');
            $table->string('brand')->nullable();
            $table->unsignedBigInteger('id_review')->default(1);
            $table->foreign('id_review')->references('id')->on('reviews')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
