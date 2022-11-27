<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function categorys()
    {
        $categories = Category::with('categories')
            ->with("categories.categories")
            ->where('parent_id', "=",0)
            ->get();

        return response()->json(['categorys' => $categories]);
    }
}
