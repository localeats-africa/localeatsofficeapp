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
        Schema::create('temp_instore_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('added_by');
            $table->string('parent');
            $table->string('vendor_id');
            $table->string('food_item');
            $table->string('category')->nullable();
            $table->string('quantity');
            $table->string('price');
            $table->string('description')->nullable();
            $table->string('date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_instore_sales');
    }
};
