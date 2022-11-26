<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'cost',
        'slug',
    ];

    /**
     * Связи
     */

    public function propertys()
    {
        return $this->hasMany(Property::class, 'product_id', 'id');
    }

    public function  category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }


    /**
     * Вспомогательные функции
     */

    // генератор уникального slug
    public static function generateUniqueCode()
    {
        do {
            $referal_code = strtolower(Str::random(20));
        } while (self::where("slug", "=", $referal_code)->first());

        return $referal_code;
    }
}
