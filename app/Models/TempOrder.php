<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempOrder extends Model
{
    use HasFactory;
    protected $table = 'temp_order';
    protected $fillable = [
        'added_by',
        'platform_id',
        'vendor_id',
        'order_ref',
        'order_amount',
        'food_menu_id',
        'food_price',
        'extra',
        'description',
        'delivery_date',   
    ];
    
}
