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
        Schema::create('multi_store', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('multi_store_name');
            $table->string('user_id');
            $table->string('vendor_id');
            $table->string('role');
            $table->string('level');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multi_store');
    }
};