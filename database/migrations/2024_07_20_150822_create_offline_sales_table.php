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
        Schema::create('offline_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->string('added_by')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('sales_item')->nullable();
            $table->string('price')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('offline_sales');
    }
};
