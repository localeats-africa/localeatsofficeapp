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
            'item'          => $row[0],   
            'category'      => $row[1],
            'added_by'      => Auth::id(),
            'vendor_id'     => $this->vendor_id,
        ]);
    }
}
