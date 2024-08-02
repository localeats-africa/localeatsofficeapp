<?php

namespace App\Imports;

use App\Models\OfflineFoodMenu;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ImportOfflineFoodMenu implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OfflineFoodMenu([
            //
        ]);
    }
}
