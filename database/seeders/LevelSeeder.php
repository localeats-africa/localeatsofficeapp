<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('level')->insert([
            'role_id'   => '1',
            'level'     => '1'
        ]);

        DB::table('level')->insert([
            'role_id'   => '2',
            'level'     => '1'
        ]);

        DB::table('level')->insert([
            'role_id'   => '3',
            'level'     => '1'
        ]);

        DB::table('level')->insert([
            'role_id'   => '4',
            'level'     => '1'
        ]);

        DB::table('level')->insert([
            'role_id'   => '5',
            'level'     => '1'
        ]);

        DB::table('level')->insert([
            'role_id'   => '6',
            'level'     => '1'
        ]);

    }
}
