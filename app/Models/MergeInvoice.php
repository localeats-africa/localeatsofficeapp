<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MergeInvoice extends Model
{
    use HasFactory;
    protected $table = 'merge_invoices';
    protected $fillable = [
        'order_id',
        'vendor_id',   
    ];
}
