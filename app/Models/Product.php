<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'category',
        'image',
        'price',
        'size',
        'description',
        'min_qty_nego',
        'is_active',
    ];
}