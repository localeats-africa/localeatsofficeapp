<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Orders;
use Auth;

class OrdersImportClass implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct(string $vendor_id, $platform_id ) {
        $this->vendor_id= $vendor_id;
        $this->platform_id =  $platform_id ;
    }

    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        // Define how to create a model from the Excel row data

        return new Orders([
            'description'   => $row[0],
            'order_ref'     => $row[1],
            'order_amount'  => $row[2],
            'delivery_date' => $row[3],
            'added_by'      => Auth::id(),
            'vendor_id'     => $this->vendor_id,
            'platform_id'   =>$this->platform_id,
            // Add more columns as needed
        ]);
    }
}
