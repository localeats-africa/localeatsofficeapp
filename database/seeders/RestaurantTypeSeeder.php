<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RestaurantTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('restaurant_type')->insert([
            'restaurant_type' => 'Physical',
        ]);
        DB::table('restaurant_type')->insert([
            'restaurant_type' => 'Hotel Kitchen',
        ]);
        DB::table('restaurant_type')->insert([
            'restaurant_type' => 'Independent Chef',
        ]);
    }
}
