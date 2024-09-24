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
        Schema::create('sub_vendor_inventory', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('vendor_id')->nullable();
            $table->string('parent_id')->nullable();
            $table->string('inventory_id')->nullable();
            $table->string('supply')->nullable();
            $table->string('supply_qty')->nullable();
            $table->string('size')->nullable();
            $table->string('weight')->nullable();
            $table->string('status')->nullable();
            $table->string('remark')->nullable();
            $table->string('date')->nullable();
            $table->string('supply_ref')->nullable();
            $table->string('number_of_items')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_vendor_inventory');
    }
};
