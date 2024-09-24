<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubVendorInventory extends Model
{
    use HasFactory, SoftDeletes;
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
     

