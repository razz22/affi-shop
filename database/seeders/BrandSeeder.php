<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Apple', 'slug' => 'apple', 'logo' => 'https://cdn.simpleicons.org/apple/111111', 'sort_order' => 1],
            ['name' => 'Samsung', 'slug' => 'samsung', 'logo' => 'https://cdn.simpleicons.org/samsung/1428A0', 'sort_order' => 2],
            ['name' => 'Sony', 'slug' => 'sony', 'logo' => 'https://cdn.simpleicons.org/sony/000000', 'sort_order' => 3],
            ['name' => 'Bose', 'slug' => 'bose', 'logo' => 'https://cdn.simpleicons.org/bose/000000', 'sort_order' => 4],
            ['name' => 'Logitech', 'slug' => 'logitech', 'logo' => null, 'sort_order' => 5],
            ['name' => 'Anker', 'slug' => 'anker', 'logo' => null, 'sort_order' => 6],
            ['name' => 'Nike', 'slug' => 'nike', 'logo' => 'https://cdn.simpleicons.org/nike/111111', 'sort_order' => 7],
            ['name' => 'LEGO', 'slug' => 'lego', 'logo' => null, 'sort_order' => 8],
        ];

        foreach ($brands as $brand) {
            Brand::updateOrCreate(
                ['slug' => $brand['slug']],
                $brand + ['is_featured' => true]
            );
        }
    }
}
