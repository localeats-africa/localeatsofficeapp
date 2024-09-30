<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOnlineSales extends Model
{
    use HasFactory;
    protected $table='vendor_online_sales';
    protected $fillable = [
        'added_by',
        'parent_id',
        'platform_id',
        'vendor_id',
        'order_ref',
        'order_amount',
        'food_menu',
        'food_price',
        'description',
        'delivery_date', 
        'status',
    ];
}
