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
            $table->string('A')->nullable();
            $table->string('B')->nullable();
            $table->string('C')->nullable();
            $table->string('D')->nullable();
            $table->string('E')->nullable();
            $table->string('F')->nullable();
            $table->string('G')->nullable();
            $table->string('H')->nullable();
            $table->string('I')->nullable();
            $table->string('J')->nullable();
            $table->string('K')->nullable();
            $table->string('L')->nullable();
            $table->string('M')->nullable();
            $table->string('N')->nullable();
            $table->string('O')->nullable();
            $table->string('P')->nullable();
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
