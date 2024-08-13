<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ChowdeckReference extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('chowdeck_reference')->insert([
            'code'          => '104563',
            'ref'           => 'NGN',
            'live_key'      => 'NGN',
            'test_key'      => 'NGN',
        ]);
    }
}
