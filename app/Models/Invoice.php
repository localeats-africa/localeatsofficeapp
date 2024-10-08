<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'final_invoice';
    protected $fillable = [
        'vendor_id',
        'invoice_url',
        'invoice_status',
        'reference',
    ];
    
}
