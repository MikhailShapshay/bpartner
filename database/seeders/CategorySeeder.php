<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\Property;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->has(
                Category::factory()
                    ->has(
                        Category::factory()
                            ->has(
                                Product::factory()
                                    ->has(
                                        Property::factory()
                                            ->count(2)
                                    )
                                    ->count(3)
                            )
                            ->count(2)
                    )
                    ->count(3)
            )
            ->count(5)
            ->create();
    }
}
