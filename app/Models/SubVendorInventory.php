<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubVendorInventory extends Model
{
    use HasFactory;
    protected $table = 'sub_vendor_inventory';
    protected $fillable = [
        'supply_qty',
        'supply',
        'vendor_id',
        'parent_id',
        'remark',
        'status',
        'inventory_id'
    ];
}
     

