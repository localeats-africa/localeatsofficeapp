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
        Schema::create('temp_order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('added_by')->nullable();
            $table->string('platform_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('food_menu_id')->nullable();
            $table->string('vendor_fee')->nullable();
            $table->string('order_ref')->nullable();
            $table->string('order_amount')->nullable();
            $table->string('extra')->nullable();
            $table->string('description')->nullable();
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
        Schema::dropIfExists('temp_order');
    }
};
