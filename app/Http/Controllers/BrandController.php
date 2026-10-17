<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersProducts;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    use FiltersProducts;

    public function show(Brand $brand, Request $request)
    {
        $query = $brand->products()->with(['images', 'category'])->active();

        if ($slug = $request->get('category')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $slug));
        }

        $this->applySort($query, $request);

        $products = $query->paginate(12)->withQueryString();

        $categories = Category::whereHas('products', fn ($q) => $q->where('brand_id', $brand->id))
            ->ordered()->get();

        $brands = Brand::ordered()->get();

        return view('brand', compact('brand', 'products', 'categories', 'brands'));
    }

    public function index()
    {
        $brands = Brand::ordered()->withCount('products')->get();

        return view('brands', compact('brands'));
    }
}
