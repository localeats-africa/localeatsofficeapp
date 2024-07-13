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
        Schema::create('vendor', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('deleted_at')->nullable();
            $table->string('vendor_status')->nullable();
            $table->string('vendor_ref')->nullable(); 
            $table->string('vendor_name')->nullable();
            $table->string('restaurant_type')->nullable(); 
            $table->string('food_type')->nullable();
            $table->string('number_of_store_locations')->nullable();
            $table->string('available_hours')->nullable();
            $table->string('delivery_time')->nullable();
            $table->string('description')->nullable();
            $table->string('contact_fname')->nullable(); 
            $table->string('contact_lname')->nullable(); 
            $table->string('contact_phone')->nullable(); 
            $table->string('email')->nullable(); 
            $table->string('address')->nullable(); 
            $table->string('state_id')->nullable(); 
            $table->string('area_id')->nullable(); 
            $table->string('country_id')->nullable(); 
            $table->string('vendor_logo')->nullable();
            $table->string('address_longitude')->nullable();
            $table->string('address_latitude')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_number')->nullable();
            $table->string('account_name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor');
    }
};
