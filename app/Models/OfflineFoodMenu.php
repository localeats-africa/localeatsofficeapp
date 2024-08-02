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
        'soup',
        'protein',
        'others',
        'vendor_id',
        'added_by',
    ];
}
