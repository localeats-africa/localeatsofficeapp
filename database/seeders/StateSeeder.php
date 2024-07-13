<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('state')->insert([
            'state' => 'Lagos',
            'country_id' => '1'
        ]);

        DB::table('state')->insert([
            'state' => 'Oyo',
            'country_id' => '1'
        ]);
    }
}
