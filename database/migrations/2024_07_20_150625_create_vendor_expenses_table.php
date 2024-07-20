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
        Schema::create('vendor_expenses', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->string('added_by')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('description')->nullable();
            $table->string('cost')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_expenses');
    }
};
