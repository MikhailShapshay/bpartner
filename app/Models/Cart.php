<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'email',
        'phone',
        'ses_id',
    ];

    /**
     * Связи
     */

    public function  user()
    {
        return $this->belongsTo(Product::class, 'user_id', 'id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'cart_id', 'id');
    }
}
