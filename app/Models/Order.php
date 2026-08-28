<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_type',
        'product_id',
        'custom_description',
        'custom_image',
        'quantity',
        'customer_name',
        'customer_contact',
        'notes',
        'status',
    ];

    public function product()
{
    return $this->belongsTo(Product::class);
}
}

