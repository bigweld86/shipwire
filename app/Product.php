<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = 'product_id';
    
    protected $fillable = [
        'product_name',
        'product_description',
        'product_price',
        'product_width',
        'product_length',
        'product_height',
        'product_weight'
    ];
}
