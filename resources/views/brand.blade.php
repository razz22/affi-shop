@extends('layouts.app')

@section('title', $brand->name)

@section('content')
<div class="container-shop py-8">

    <nav class="mb-4 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a> /
        <a href="{{ route('brands.index') }}" class="hover:text-brand-dark">Brands</a> /
        <span class="text-slate-700">{{ $brand->name }}</span>
    </nav>

    <div class="mb-6 flex items-center gap-4">
        <div class="flex h-16 w-16 items-center justify-center rounded-xl border border-slate-200 bg-white p-2">
            @if ($brand->image_url)
                <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" class="max-h-full max-w-full object-contain">
            @endif
        </div>
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $brand->name }}</h1>
            <p class="mt-1 text-sm text-slate-400">{{ $products->total() }} products</p>
        </div>
    </div>

    <div class="flex flex-col gap-8 lg:flex-row">
        <aside class="w-full shrink-0 lg:w-56">
            @if ($categories->isNotEmpty())
                <div class="card p-4">
                    <h3 class="mb-3 text-sm font-bold text-navy-900">Categories</h3>
                    <ul class="space-y-1.5 text-sm">
                        <li>
                            <a href="{{ route('brand.show', $brand) }}"
                               class="block rounded px-2 py-1 {{ ! request('category') ? 'bg-brand/10 font-semibold text-brand-dark' : 'text-slate-600 hover:bg-slate-100' }}">
                                All Categories
                            </a>
                        </li>
                        @foreach ($categories as $cat)
                            <li>
                                <a href="{{ route('brand.show', [$brand, 'category' => $cat->slug]) }}"
                                   class="block rounded px-2 py-1 {{ request('category') === $cat->slug ? 'bg-brand/10 font-semibold text-brand-dark' : 'text-slate-600 hover:bg-slate-100' }}">
                                    {{ $cat->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </aside>

        <div class="flex-1">
            <div class="mb-4 flex justify-end">
                <form method="GET" class="flex items-center gap-2 text-sm">
                    @if (request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <label for="sort" class="text-slate-500">Sort by</label>
                    <select name="sort" id="sort" onchange="this.form.submit()" class="input w-auto">
                        <option value="">Most Popular</option>
                        <option value="newest" @selected(request('sort') === 'newest')>Newest</option>
                        <option value="price_low" @selected(request('sort') === 'price_low')>Price: Low to High</option>
                        <option value="price_high" @selected(request('sort') === 'price_high')>Price: High to Low</option>
                        <option value="rating" @selected(request('sort') === 'rating')>Highest Rated</option>
                    </select>
                </form>
            </div>

            @if ($products->isEmpty())
                <div class="card p-10 text-center text-slate-400">
                    <i class="fa-solid fa-box-open mb-3 text-4xl"></i>
                    <p>No products found for this brand yet.</p>
                </div>
            @else
                <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
                    @foreach ($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>
                <div class="mt-8">{{ $products->links() }}</div>
            @endif
        </div>
    </div>
</div>
@endsection
