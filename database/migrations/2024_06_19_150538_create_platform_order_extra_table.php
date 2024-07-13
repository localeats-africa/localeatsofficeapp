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
        Schema::create('platform_order_extra', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_id')->nullable();
            $table->string('quantity')->nullable();
            $table->string('price_per_quantity')->nullable();
            $table->string('item_code')->nullable();
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
        Schema::dropIfExists('platform_order_extra');
    }
};
