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

    public function  __construct(string $vendor_id) {
        $this->vendor_id= $vendor_id;
    }

    public function model(array $row)
    {
        return new OfflineFoodMenu([
            //
            'swallow'       => $row[0],
            'swallow_price' => $row[1],     
            'soup'          => $row[2],
            'soup_price'    => $row[3],
            'protein'       => $row[4],
            'protein_price' => $row[5],
            'others'        => $row[6],
            'others_price'  => $row[7],
            'added_by'      => Auth::id(),
            'vendor_id'     => $this->vendor_id,
        ]);
    }
}
