<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Carbon\CarbonPeriod;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      

        DB::table('users')->insert([
            'role_id'   => '6',
            'name'      => 'Vendor Account',
            'email'     => 'techvendor@localeats.africa',
            'password'  => Hash::make('12345678'),
            'email_verified_at' => Carbon::now()
            
        ]);
    }
}
