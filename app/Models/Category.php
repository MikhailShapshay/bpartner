<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'title',
    ];

    /**
     * Связи
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

}
