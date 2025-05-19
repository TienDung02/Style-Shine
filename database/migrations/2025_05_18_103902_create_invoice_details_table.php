<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::dropIfExists('invoice_details');
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->string('id_invoice', 50);
            $table->string('id_product', 50);
            $table->integer('quality');
            $table->foreign('id_invoice')->references('id')->on('invoices');
            $table->foreign('id_product')->references('id_product')->on('products');
//            $table->primary(['id_invoice', 'id_product']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
