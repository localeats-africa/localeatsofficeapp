<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodCategory extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'food_category';
    protected $fillable = [
        'category',
        'vendor_id',
        'store_id',
    ];
}
