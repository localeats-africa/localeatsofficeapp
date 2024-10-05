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
        Schema::create('vendor_glovo_import_sales', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('a')->nullable();
            $table->string('b')->nullable();
            $table->string('c')->nullable();
            $table->string('d')->nullable();
            $table->string('e')->nullable();
            $table->string('f')->nullable();
            $table->string('g')->nullable();
            $table->string('h')->nullable();
            $table->string('i')->nullable();
            $table->string('j')->nullable();
            $table->string('k')->nullable();
            $table->string('l')->nullable();
            $table->string('m')->nullable();
            $table->string('n')->nullable();
            $table->string('o')->nullable();
            $table->string('p')->nullable();
            $table->string('added_by')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('vendor_id')->nullable();
            $table->string('platform_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_glovo_import_sales');
    }
};
