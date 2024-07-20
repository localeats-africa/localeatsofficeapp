<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('role')->insert([
            'role_name' => 'superadmin',
        ]);

        DB::table('role')->insert([
            'role_name' => 'admin',
        ]);

        DB::table('role')->insert([
            'role_name' => 'manager',
        ]);

        DB::table('role')->insert([
            'role_name' => 'finance',
        ]);

        DB::table('role')->insert([
            'role_name' => 'auditor',
        ]);

        DB::table('role')->insert([
            'role_name' => 'vendormanager',
        ]);
        DB::table('role')->insert([
            'role_name' => 'cashier',
        ]);
    }
}
