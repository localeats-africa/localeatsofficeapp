<?php

namespace App\Imports;

use App\Models\VendorGlovoImportSales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\DB;

use Auth;

class ImportVendorGlovoSales implements ToModel
{
    /**
    * @param Collection $collection
    */

    public function  __construct(string $parent_id, $vendor_id, $platform_id) {
        $this->parent_id    = $parent_id ;
        $this->vendor_id    = $vendor_id;
        $this->platform_id  = $platform_id ;
       
    }

    public function collection(Collection $collection)
    {
        //
    }
    public function model(array $row)
    {
        return new VendorGlovoImportSales([
            'a'     => $row[0],
            'b'     => $row[1],
            'c'     => $row[2],
            'e'     => $row[3],
            'f'     => $row[4],
            'g'     => $row[5],
            'h'     => $row[6],
            'i'     => $row[7],
            'j'     => $row[8],
            'k'     => $row[9],
            'l'     => $row[10],
            'm'     => $row[11],
            'n'     => $row[12],
            'o'     => $row[13],
            'p'     => $row[14],
            'added_by' => Auth::user()->id,
            'parent_id'     => $this->platform_id,
            'vendor_id'     => $this->vendor_id,
            'platform_id'   => $this->platform_id,
        ]);
    }
}
