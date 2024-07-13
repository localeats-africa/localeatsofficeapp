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
        Schema::create('platform_vendor', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('vendor_address')->nullable();
            $table->string('vendor_coordinate_x')->nullable();
            $table->string('vendor_coordinate_y')->nullable();
            $table->string('vendor_state')->nullable();
            $table->string('vendor_city')->nullable();
            $table->string('vendor_country')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_vendor');
    }
};
