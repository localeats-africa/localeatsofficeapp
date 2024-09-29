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
        Schema::create('vendor_expenses_category', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->string('parent');
            $table->string('vendor_id');
            $table->string('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_expenses_category');
    }
};
