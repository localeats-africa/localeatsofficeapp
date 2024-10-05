<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorGlovoImportSales extends Model
{
    use HasFactory;
    protected $table = 'vendor_glovo_import_sales';
    protected $fillable = [
        'a',
        'b',
        'c',
        'd',
        'e',
        'f',
        'g', 
        'h',
        'i',
        'j',
        'k',
        'l',
        'm',
        'n',
        'o',
        'p',
        'p',
        'added_by',
        'platform_id',
        'vendor_id',
    ];
}
