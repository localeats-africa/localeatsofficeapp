<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpensesList extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'expenses_list'; 
    protected $fillable = [
        'item',
        'vendor_id',
        'added_by',
    ];
}
