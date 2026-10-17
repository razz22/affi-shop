@extends('layouts.admin')

@section('title', $product->exists ? 'Edit Product' : 'Add Product')

@section('content')
<form method="POST"
      action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}"
      enctype="multipart/form-data" class="grid grid-cols-1 gap-6 lg:grid-cols-3">
    @csrf
    @if ($product->exists) @method('PUT') @endif

    <div class="space-y-6 lg:col-span-2">
        <div class="card space-y-5 p-6">
            <h2 class="text-sm font-bold text-navy-900">Basic Information</h2>

            <div>
                <label for="name" class="label">Product Name</label>
                <input type="text" name="name" id="name" value="{{ old('name', $product->name) }}" required class="input">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="category_id" class="label">Category</label>
                    <select name="category_id" id="category_id" class="input">
                        <option value="">&mdash; None &mdash;</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('category_id', $product->category_id) == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="brand_id" class="label">Brand</label>
                    <select name="brand_id" id="brand_id" class="input">
                        <option value="">&mdash; None &mdash;</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" @selected(old('brand_id', $product->brand_id) == $brand->id)>{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div>
                <label for="sku" class="label">SKU (optional)</label>
                <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}" class="input">
            </div>

            <div>
                <label for="short_description" class="label">Short Description</label>
                <textarea name="short_description" id="short_description" rows="2" class="input">{{ old('short_description', $product->short_description) }}</textarea>
            </div>

            <div>
                <label for="description" class="label">Full Description</label>
                <textarea name="description" id="description" rows="8" class="input font-mono text-xs">{{ old('description', $product->description) }}</textarea>
                <p class="mt-1 text-xs text-slate-400">Basic HTML is supported: &lt;p&gt;, &lt;ul&gt;/&lt;li&gt;, &lt;strong&gt;, etc.</p>
            </div>
        </div>

        <div class="card space-y-5 p-6">
            <h2 class="text-sm font-bold text-navy-900">Pricing &amp; Affiliate Link</h2>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="label">Price ($)</label>
                    <input type="number" step="0.01" min="0" name="price" id="price" value="{{ old('price', $product->price) }}" required class="input">
                </div>
                <div>
                    <label for="discount_price" class="label">Discount Price ($, optional)</label>
                    <input type="number" step="0.01" min="0" name="discount_price" id="discount_price" value="{{ old('discount_price', $product->discount_price) }}" class="input">
                </div>
            </div>

            <div>
                <label for="affiliate_link" class="label">Amazon Affiliate Link</label>
                <input type="url" name="affiliate_link" id="affiliate_link" value="{{ old('affiliate_link', $product->affiliate_link) }}" required placeholder="https://www.amazon.com/dp/XXXXXXXXXX?tag=yourid-20" class="input">
            </div>
        </div>

        <div class="card space-y-5 p-6">
            <h2 class="text-sm font-bold text-navy-900">Images</h2>

            @if ($product->exists && $product->images->isNotEmpty())
                <div class="grid grid-cols-3 gap-3 sm:grid-cols-4">
                    @foreach ($product->images as $image)
                        <div class="group relative overflow-hidden rounded-lg border border-slate-200">
                            <img src="{{ $image->image_url }}" class="h-24 w-full object-cover">
                            @if ($image->is_primary)
                                <span class="absolute left-1 top-1 rounded-full bg-brand px-2 py-0.5 text-[10px] font-bold text-navy-900">Primary</span>
                            @endif
                            <div class="absolute inset-x-0 bottom-0 flex justify-center gap-2 bg-black/50 py-1 opacity-0 group-hover:opacity-100">
                                @if (! $image->is_primary)
                                    <form method="POST" action="{{ route('admin.products.images.primary', [$product, $image]) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="text-xs text-white hover:text-brand" title="Make primary"><i class="fa-solid fa-star"></i></button>
                                    </form>
                                @endif
                                <form method="POST" action="{{ route('admin.products.images.destroy', [$product, $image]) }}" onsubmit="return confirm('Remove this image?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-xs text-white hover:text-deal" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <div>
                <label class="label">{{ $product->exists ? 'Add More Images' : 'Product Images' }}</label>
                <input type="file" name="images[]" accept="image/*" multiple class="input">
                <p class="mt-1 text-xs text-slate-400">First uploaded image becomes primary if none is set yet.</p>
            </div>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card space-y-4 p-6">
            <h2 class="text-sm font-bold text-navy-900">Status &amp; Badges</h2>

            <div>
                <label for="stock_status" class="label">Stock Status</label>
                <select name="stock_status" id="stock_status" class="input">
                    <option value="in_stock" @selected(old('stock_status', $product->stock_status ?? 'in_stock') === 'in_stock')>In Stock</option>
                    <option value="limited" @selected(old('stock_status', $product->stock_status) === 'limited')>Limited Stock</option>
                    <option value="out_of_stock" @selected(old('stock_status', $product->stock_status) === 'out_of_stock')>Out of Stock</option>
                </select>
            </div>

            <div>
                <label for="badge" class="label">Badge Text (optional)</label>
                <input type="text" name="badge" id="badge" value="{{ old('badge', $product->badge) }}" placeholder="Amazon's Choice, Best Seller..." class="input">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="rating" class="label">Rating (0-5)</label>
                    <input type="number" step="0.1" min="0" max="5" name="rating" id="rating" value="{{ old('rating', $product->rating ?? 4.5) }}" class="input">
                </div>
                <div>
                    <label for="rating_count" class="label">Rating Count</label>
                    <input type="number" min="0" name="rating_count" id="rating_count" value="{{ old('rating_count', $product->rating_count ?? 0) }}" class="input">
                </div>
            </div>

            <div class="space-y-2 pt-2">
                @php
                    $flags = [
                        'status' => 'Published (visible on site)',
                        'is_featured' => 'Featured on homepage',
                        'is_bestseller' => 'Best Seller',
                        'is_deal' => "Today's Deal",
                        'is_new' => 'New Arrival',
                        'is_gift_card' => 'Gift Card',
                    ];
                @endphp
                @foreach ($flags as $key => $flagLabel)
                    <label class="flex items-center gap-2 text-sm font-medium text-slate-700">
                        <input type="checkbox" name="{{ $key }}" value="1"
                               @checked(old($key, $product->exists ? $product->$key : ($key === 'status')))
                               class="rounded border-slate-300">
                        {{ $flagLabel }}
                    </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3">
            <button type="submit" class="btn-brand flex-1"><i class="fa-solid fa-floppy-disk"></i> Save Product</button>
        </div>
        <a href="{{ route('admin.products.index') }}" class="btn-outline w-full">Cancel</a>
    </div>
</form>
@endsection
