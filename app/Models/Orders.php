<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
    protected $table = 'orders';
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
        'refund', 
        'delivery_fee',   
        'delivery_partner',  
        'commission',  
        'number_of_order_merge',
        'payout',
        'payment_status',
        'invoice_ref',
        'past_number_of_orders',
        'past_number_of_plates'
    ];
}
