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
        Schema::create('platform_orders', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vendor_id')->nullable();
            $table->string('platform_id')->nullable();
            $table->string('order_ref')->nullable();
            $table->string('order_code')->nullable();
            $table->string('order_status')->nullable();
            $table->string('delivery_price')->nullable();
            $table->string('total_price')->nullable();
            $table->string('summary')->nullable();
            $table->string('delivery_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_orders');
    }
};
