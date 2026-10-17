<?php

namespace Database\Seeders;

use App\Models\HeroBanner;
use Illuminate\Database\Seeder;

class HeroBannerSeeder extends Seeder
{
    public function run(): void
    {
        $banners = [
            [
                'title' => 'Big Summer Electronics Sale',
                'subtitle' => 'Up to 60% off headphones, laptops & more',
                'image' => 'https://images.unsplash.com/photo-1550009158-9ebf69173e03?w=1600&q=70',
                'link' => 'https://www.amazon.com/deals?tag=youraffiliateid-20',
                'button_text' => 'Shop the Sale',
                'bg_color' => '#232f3e',
                'sort_order' => 1,
            ],
            [
                'title' => 'New Season Fashion Arrivals',
                'subtitle' => 'Refresh your wardrobe for less',
                'image' => 'https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?w=1600&q=70',
                'link' => 'https://www.amazon.com/fashion?tag=youraffiliateid-20',
                'button_text' => 'Explore Fashion',
                'bg_color' => '#146eb4',
                'sort_order' => 2,
            ],
            [
                'title' => 'Gift Cards for Every Occasion',
                'subtitle' => 'Instant delivery, zero hassle',
                'image' => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=1600&q=70',
                'link' => 'https://www.amazon.com/gift-cards?tag=youraffiliateid-20',
                'button_text' => 'Buy a Gift Card',
                'bg_color' => '#c45500',
                'sort_order' => 3,
            ],
        ];

        foreach ($banners as $banner) {
            HeroBanner::updateOrCreate(['title' => $banner['title']], $banner + ['is_active' => true]);
        }
    }
}
