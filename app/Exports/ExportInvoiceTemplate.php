<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ExportInvoiceTemplate implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Orders::where('deleted_at', null)
        ->get(['description', 'order_ref', 'order_amount', 'created_at'])->take(5);
    }
}
