<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class VendorInvendorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
         

        DB::table('vendor_inventory')->insert([
            'multi_store_id'   => '1',
            'item'              => 'Bread',
            'quantity'          => null,
            
        ]);
    }
}
