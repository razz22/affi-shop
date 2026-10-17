<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'icon' => 'fa-mobile-alt', 'is_featured' => true, 'sort_order' => 1,
                'image' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?w=400&q=60'],
            ['name' => 'Computers & Accessories', 'slug' => 'computers-accessories', 'icon' => 'fa-laptop', 'is_featured' => true, 'sort_order' => 2,
                'image' => 'https://images.unsplash.com/photo-1517336714731-489689fd1ca8?w=400&q=60'],
            ['name' => 'Home & Kitchen', 'slug' => 'home-kitchen', 'icon' => 'fa-blender', 'is_featured' => true, 'sort_order' => 3,
                'image' => 'https://images.unsplash.com/photo-1583847268964-b28dc8f51f92?w=400&q=60'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'icon' => 'fa-tshirt', 'is_featured' => true, 'sort_order' => 4,
                'image' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?w=400&q=60'],
            ['name' => 'Beauty & Personal Care', 'slug' => 'beauty-personal-care', 'icon' => 'fa-spa', 'is_featured' => true, 'sort_order' => 5,
                'image' => 'https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=400&q=60'],
            ['name' => 'Sports & Outdoors', 'slug' => 'sports-outdoors', 'icon' => 'fa-dumbbell', 'is_featured' => true, 'sort_order' => 6,
                'image' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=400&q=60'],
            ['name' => 'Toys & Games', 'slug' => 'toys-games', 'icon' => 'fa-gamepad', 'is_featured' => true, 'sort_order' => 7,
                'image' => 'https://images.unsplash.com/photo-1585366119957-e9730b6d0f60?w=400&q=60'],
            ['name' => 'Books', 'slug' => 'books', 'icon' => 'fa-book', 'is_featured' => true, 'sort_order' => 8,
                'image' => 'https://images.unsplash.com/photo-1512820790803-83ca734da794?w=400&q=60'],
            ['name' => 'Gift Cards', 'slug' => 'gift-cards', 'icon' => 'fa-gift', 'is_featured' => false, 'sort_order' => 9,
                'image' => 'https://images.unsplash.com/photo-1607344645866-009c320b63e0?w=400&q=60'],
            ['name' => 'Watches', 'slug' => 'watches', 'icon' => 'fa-clock', 'is_featured' => false, 'sort_order' => 10,
                'image' => 'https://images.unsplash.com/photo-1524805444758-089113d48a6d?w=400&q=60'],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(['slug' => $category['slug']], $category);
        }
    }
}
