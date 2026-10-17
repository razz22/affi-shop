<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\HeroBanner;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::active()->ordered()->get();

        $categories = Category::featured()->ordered()->get();

        $brands = Brand::featured()->ordered()->get();

        $withImages = fn ($query) => $query->with(['images', 'category', 'brand'])->active();

        $deals = $withImages(Product::deal())->latest()->take(8)->get();

        $giftCards = $withImages(Product::giftCard())->take(4)->get();

        $bestSellers = $withImages(Product::bestseller())->take(8)->get();

        $popular = $withImages(Product::query())->popular()->take(8)->get();

        $newArrivals = $withImages(Product::newArrival())->latest()->take(8)->get();

        $featured = $withImages(Product::featured())->take(8)->get();

        return view('home', compact(
            'banners', 'categories', 'brands', 'deals', 'giftCards',
            'bestSellers', 'popular', 'newArrivals', 'featured'
        ));
    }
}
