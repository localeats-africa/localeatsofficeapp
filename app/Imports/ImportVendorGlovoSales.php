<?php

namespace App\Imports;

use App\Models\VendorGlovoImportSales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportVendorGlovoSales implements ToModel, WithHeadingRow
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
            'a'     => $row['a'],
            'b'     => $row['b'],
            'c'     => $row['c'],
            'e'     => $row['e'],
            'f'     => $row['f'],
            'g'     => $row['g'],
            'h'     => $row['h'],
            'i'     => $row['i'],
            'j'     => $row['j'],
            'k'     => $row['k'],
            'l'     => $row['l'],
            'm'     => $row['m'],
            'n'     => $row['n'],
            'o'     => $row['o'],
            'p'     => $row['p'],
            'added_by' => Auth::user()->id,
            'parent_id'     => $this->platform_id,
            'vendor_id'     => $this->vendor_id,
            'platform_id'   => $this->platform_id,
        ]);
    }
}
