<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VendorFoodMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vendor_food_menu';
    protected $fillable = [
        'category',
        'vendor_id',
        'store_id',
        'food_item',
        'price',
        'description'
    ];
}
