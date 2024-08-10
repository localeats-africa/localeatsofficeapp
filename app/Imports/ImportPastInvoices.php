<?php

namespace App\Imports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Facades\DB;
use App\Models\TempOrder;

use Auth;

class ImportPastInvoices implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function  __construct(string $vendor_id, $invoice_ref ) {
        $this->vendor_id= $vendor_id;
        $this->invoice_ref  = $invoice_ref;
    }

    public function collection(Collection $collection)
    {
        //
    }

    public function model(array $row)
    {
        return new Orders([
            'order_amount'  => $row[0],
            'payout'        => $row[1],
            'delivery_date' => $row[2],
            'added_by'      => Auth::id(),
            'order_ref'     => $this->invoice_ref,
            'invoice_ref'   =>  $this->invoice_ref,
            'vendor_id'     => $this->vendor_id,
        ]);
    }
}
