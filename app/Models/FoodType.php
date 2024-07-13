<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class FoodType extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'food_type';
    

    public function vendor(){
        //return $this->hasMany(Vendor::class);
        return $this->belongsTo(Vendor::class, 'food_type');
        }
}
