<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'cart_id',
        'product_id',
        'quantity',
    ];

    /**
     * Связи
     */

    public function  cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    public function products()
    {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }
}
