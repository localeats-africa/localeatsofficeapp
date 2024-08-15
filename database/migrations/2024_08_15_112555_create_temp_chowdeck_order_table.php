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
        Schema::create('temp_chowdeck_order', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vendor_id');
            $table->string('vendor_code');
            $table->string('reference');
            $table->string('order_id');
            $table->string('order_created_at');
            $table->string('order_updated_at');
            
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('temp_chowdeck_order');
    }
};
