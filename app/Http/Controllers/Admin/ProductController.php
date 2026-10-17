<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($term = $request->get('q')) {
            $query->where('name', 'like', "%{$term}%");
        }

        $products = $query->latest()->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.form', [
            'product' => new Product,
            'categories' => Category::ordered()->get(),
            'brands' => Brand::ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Product::generateUniqueSlug($data['name']);

        $product = Product::create($data);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $product->load('images');

        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::ordered()->get(),
            'brands' => Brand::ordered()->get(),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $product->name) {
            $data['slug'] = Product::generateUniqueSlug($data['name'], $product->id);
        }

        $product->update($data);

        $this->storeImages($request, $product);

        return redirect()->route('admin.products.index')->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            if (! str_starts_with($image->image, 'http')) {
                Storage::disk('public')->delete($image->image);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('status', 'Product deleted.');
    }

    private function storeImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $hasPrimary = $product->images()->where('is_primary', true)->exists();
        $nextOrder = (int) $product->images()->max('sort_order');

        foreach ($request->file('images') as $file) {
            $nextOrder++;
            $product->images()->create([
                'image' => $file->store('products', 'public'),
                'is_primary' => ! $hasPrimary && $nextOrder === 1,
                'sort_order' => $nextOrder,
            ]);
            $hasPrimary = true;
        }
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'sku' => ['nullable', 'string', 'max:60'],
            'short_description' => ['nullable', 'string', 'max:500'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'affiliate_link' => ['required', 'url', 'max:1000'],
            'badge' => ['nullable', 'string', 'max:60'],
            'rating' => ['nullable', 'numeric', 'min:0', 'max:5'],
            'rating_count' => ['nullable', 'integer', 'min:0'],
            'stock_status' => ['required', 'in:in_stock,out_of_stock,limited'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:4096'],
        ]);

        foreach (['is_featured', 'is_bestseller', 'is_deal', 'is_gift_card', 'is_new', 'status'] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        $data['rating'] = $data['rating'] ?? 4.5;
        $data['rating_count'] = $data['rating_count'] ?? 0;

        unset($data['images']);

        return $data;
    }
}
