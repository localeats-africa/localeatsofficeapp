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
        Schema::create('platform_customer', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('order_id')->nullable();
            $table->string('customer_code')->nullable();
            $table->string('customer_fname')->nullable();
            $table->string('customer_lname')->nullable();
            $table->string('customer_email')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_country')->nullable();
            $table->string('customer_address')->nullable();
            $table->string('coordinate_x')->nullable();
            $table->string('coordinate_y')->nullable();
            $table->string('customer_state')->nullable();
            $table->string('customer_city')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('platform_customer');
    }
};
