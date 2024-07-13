<?php

namespace App\Exports;

use App\Models\Orders;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ExportOrderList implements FromCollection
{
    public function  __construct(string $invoice_ref, $vendor_id ) {
        $this->vendor_id= $vendor_id;
        $this->invoice_ref =  $invoice_ref ;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Orders::leftJoin('merge_invoices', 'orders.id', '=', 'merge_invoices.order_id')
        ->leftJoin('vendor', 'orders.vendor_id', '=', 'vendor.id')
        ->where('orders.vendor_id',  $this->vendor_id)
        ->where('orders.invoice_ref', $this->invoice_ref)
        ->where('orders.deleted_at', null)
        ->get(['vendor.vendor_name',
        'orders.description', 
        'orders.order_ref',
        'orders.order_amount',
        'orders.delivery_date',
        'orders.food_price',
        'orders.extra',
        'orders.payout'
       ]);
    }
}
