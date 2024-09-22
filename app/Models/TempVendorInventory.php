<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempVendorInventory extends Model
{
    use HasFactory;
    protected $table = 'temp_vendor_inventory';
    protected $fillable = [
        'supply_qty',
        'supply',
        'vendor_id',
        'parent_id',
        'inventory_id'
    ];
    
}
