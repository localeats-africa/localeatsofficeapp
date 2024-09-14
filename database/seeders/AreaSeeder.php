<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ikeja'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Oba Akran-Ikeja'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Computer Village-Ikeja'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ojota'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ogudu'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Okota'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ago Palace'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Shomolu'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Fadeyi'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Yaba'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Alagomeji-Yaba'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Akoka'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Finbar Akoka-Yaba'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Sabo-Yaba'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Modele-Yaba'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Gbagada'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ifako-Gbagada'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Anthony'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ilasan'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'VGC'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ilupeju'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Maza-Maza'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ojo'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ojo-Barracks'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Police Barracks'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Bode-Thomas'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Akerele-Surulere'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Lawanson-Surulere'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ebute-meta'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Railway Compound Ebute-meta'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Randle Road-Apapa'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Abbatoir Agege-2'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Festac'
        ]);

        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Egbeda'
        ]);
        DB::table('area')->insert([
            'state_id' => '1',
            'area' => 'Ikorodu'
        ]);

      //Oyo State
      DB::table('area')->insert([
        'state_id' => '2',
        'area' => 'Agodi'
    ]);

    DB::table('area')->insert([
        'state_id' => '2',
        'area' => 'Samonda'
    ]);

    DB::table('area')->insert([
        'state_id' => '2',
        'area' => 'Agbowo UI'
    ]);

    DB::table('area')->insert([
        'state_id' => '2',
        'area' => 'Ring Road'
    ]);

 

    }
}
