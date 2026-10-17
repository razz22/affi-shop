<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersProducts;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use FiltersProducts;

    public function index(Request $request)
    {
        $term = trim((string) $request->get('q'));

        $query = Product::with(['images', 'brand', 'category'])->active();

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                    ->orWhere('short_description', 'like', "%{$term}%")
                    ->orWhereHas('category', fn ($c) => $c->where('name', 'like', "%{$term}%"))
                    ->orWhereHas('brand', fn ($b) => $b->where('name', 'like', "%{$term}%"));
            });
        }

        $this->applySort($query, $request);

        $products = $query->paginate(12)->withQueryString();

        return view('search', [
            'products' => $products,
            'term' => $term,
        ]);
    }
}
