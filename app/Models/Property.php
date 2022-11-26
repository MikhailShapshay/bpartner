<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'title',
        'value',
    ];

    /**
     * Связи
     */

    public function  product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
