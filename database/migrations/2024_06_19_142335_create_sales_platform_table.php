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
        Schema::create('sales_platform', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vendor_id')->nullable();
            $table->string('platform_status')->nullable();
            $table->string('platform_name')->nullable();
            $table->string('platform_ref')->nullable();
            $table->string('platform_logo')->nullable();
            $table->string('deleted_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_platform');
    }
};
