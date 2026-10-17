<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use FiltersProducts;

    public function show(Product $product)
    {
        abort_unless($product->status, 404);

        $product->load(['images', 'category', 'brand']);
        $product->increment('views');

        $related = Product::with('images')
            ->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->inRandomOrder()
            ->take(8)
            ->get();

        $others = Product::with('images')
            ->active()
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', '!=', $product->category_id))
            ->inRandomOrder()
            ->take(8)
            ->get();

        return view('product', compact('product', 'related', 'others'));
    }

    public function bestsellers(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category'])->active()->bestseller();
        $this->applySort($query, $request);
        $products = $query->paginate(12)->withQueryString();

        return view('listing', [
            'products' => $products,
            'title' => 'Best Sellers',
            'subtitle' => 'The most loved products by our shoppers',
        ]);
    }

    public function newArrivals(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category'])->active()->newArrival()->latest();
        $products = $query->paginate(12)->withQueryString();

        return view('listing', [
            'products' => $products,
            'title' => 'New Arrivals',
            'subtitle' => 'Fresh finds just added to the store',
        ]);
    }

    public function popular(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category'])->active()->popular();
        $products = $query->paginate(12)->withQueryString();

        return view('listing', [
            'products' => $products,
            'title' => 'Popular Right Now',
            'subtitle' => 'Trending products loved by the crowd',
        ]);
    }

    public function giftCards(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category'])->active()->giftCard();
        $products = $query->paginate(12)->withQueryString();

        return view('listing', [
            'products' => $products,
            'title' => 'Gift Cards',
            'subtitle' => 'The perfect gift for any occasion',
        ]);
    }
}
