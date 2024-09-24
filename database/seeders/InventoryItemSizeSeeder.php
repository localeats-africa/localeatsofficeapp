<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InventoryItemSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        
        DB::table('inventory_item_size')->insert([
            'size'   => 'peices'
            
        ]);
        DB::table('inventory_item_size')->insert([
            'size'   => 'liter'
        ]);

        DB::table('inventory_item_size')->insert([
            'size'   => 'dozen' 
        ]);
        DB::table('inventory_item_size')->insert([
            'size'   => 'kg'
        ]);
        DB::table('inventory_item_size')->insert([
            'size'   => 'g'
        ]);
        DB::table('inventory_item_size')->insert([
            'size'   => 'ton'
        ]);

       
      
     
        

       
    }
}
