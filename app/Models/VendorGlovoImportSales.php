<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorGlovoImportSales extends Model
{
    use HasFactory;
    protected $table = 'vendor_glovo_import_sales';
    protected $fillable = [
        'A',
        'B',
        'C',
        'D',
        'E',
        'F',
        'G', 
        'H',
        'I',
        'J',
        'K',
        'L',
        'M',
        'N',
        'O',
        'P',
        'parent_id',
        'platform_id',
        'vendor_id',
    ];
}
