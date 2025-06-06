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
        Schema::dropIfExists('brands');
//        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Schema::create('brands', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->string('name');
            $table->text('desc');
            $table->text('logo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('brands');
    }
};
