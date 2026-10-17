<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class DealController extends Controller
{
    use FiltersProducts;

    public function index(Request $request)
    {
        $query = Product::with(['images', 'brand', 'category'])->active()->deal();
        $this->applySort($query, $request);
        $products = $query->paginate(12)->withQueryString();

        return view('listing', [
            'products' => $products,
            'title' => "Today's Deals",
            'subtitle' => 'Limited-time discounts across every category',
        ]);
    }
}
