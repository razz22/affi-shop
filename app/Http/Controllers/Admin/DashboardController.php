<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\HeroBanner;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'categories' => Category::count(),
            'brands' => Brand::count(),
            'banners' => HeroBanner::count(),
            'clicks' => Product::sum('clicks'),
            'views' => Product::sum('views'),
        ];

        $topClicked = Product::orderByDesc('clicks')->take(5)->get();
        $recentProducts = Product::with(['category', 'brand'])->latest()->take(8)->get();

        return view('admin.dashboard', compact('stats', 'topClicked', 'recentProducts'));
    }
}
