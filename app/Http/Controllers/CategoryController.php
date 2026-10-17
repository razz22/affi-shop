<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersProducts;
use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use FiltersProducts;

    public function show(Category $category, Request $request)
    {
        $query = $category->products()->with(['images', 'brand'])->active();

        $this->applyBrandFilter($query, $request);
        $this->applySort($query, $request);

        $products = $query->paginate(12)->withQueryString();

        $brands = Brand::whereHas('products', fn ($q) => $q->where('category_id', $category->id))
            ->ordered()->get();

        $categories = Category::ordered()->get();

        return view('category', compact('category', 'products', 'brands', 'categories'));
    }
}
