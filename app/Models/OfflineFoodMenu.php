<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OfflineFoodMenu extends Model
{
    use HasFactory;
    protected $table = 'offline_foodmenu';
    protected $fillable = [
        'item',
        'swallow',
        'swallow_price',
        'soup',
        'soup_price' ,
        'protein',
        'protein_price',
        'others',
        'others_price',
        'vendor_id',
        'added_by',
    ];
}
