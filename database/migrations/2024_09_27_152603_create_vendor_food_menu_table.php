<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_food_menu', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vendor_id')->nullable();
            $table->string('store_id')->nullable();
            $table->string('category')->nullable();
            $table->string('food_item')->nullable();
            $table->string('price')->nullable();
            $table->string('description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_food_menu');
    }
};
