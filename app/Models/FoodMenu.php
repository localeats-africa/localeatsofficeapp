<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodMenu extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'food_menu';
    protected $fillable = [
        'item',
        'price',
        'vendor_id',
        'description',
        'added_by',
    ];
}
