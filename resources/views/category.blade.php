@extends('layouts.app')

@section('title', $category->name)

@section('content')
<div class="container-shop py-8">

    <nav class="mb-4 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a> /
        <span class="text-slate-700">{{ $category->name }}</span>
    </nav>

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $category->name }}</h1>
            @if ($category->description)
                <p class="mt-1 text-sm text-slate-500">{{ $category->description }}</p>
            @endif
            <p class="mt-1 text-sm text-slate-400">{{ $products->total() }} products</p>
        </div>
    </div>

    <div class="flex flex-col gap-8 lg:flex-row">
        {{-- Sidebar --}}
        <aside class="w-full shrink-0 lg:w-56">
            <div class="card p-4">
                <h3 class="mb-3 text-sm font-bold text-navy-900">Categories</h3>
                <ul class="space-y-1.5 text-sm">
                    @foreach ($categories as $cat)
                        <li>
                            <a href="{{ route('category.show', $cat) }}"
                               class="block rounded px-2 py-1 {{ $cat->id === $category->id ? 'bg-brand/10 font-semibold text-brand-dark' : 'text-slate-600 hover:bg-slate-100' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                @if ($brands->isNotEmpty())
                    <h3 class="mb-3 mt-6 text-sm font-bold text-navy-900">Brands</h3>
                    <ul class="space-y-1.5 text-sm">
                        <li>
                            <a href="{{ route('category.show', $category) }}"
                               class="block rounded px-2 py-1 {{ ! request('brand') ? 'bg-brand/10 font-semibold text-brand-dark' : 'text-slate-600 hover:bg-slate-100' }}">
                                All Brands
                            </a>
                        </li>
                        @foreach ($brands as $brand)
                            <li>
                                <a href="{{ route('category.show', [$category, 'brand' => $brand->slug]) }}"
                                   class="block rounded px-2 py-1 {{ request('brand') === $brand->slug ? 'bg-brand/10 font-semibold text-brand-dark' : 'text-slate-600 hover:bg-slate-100' }}">
                                    {{ $brand->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </aside>

        {{-- Products --}}
        <div class="flex-1">
            <div class="mb-4 flex justify-end">
                <form method="GET" class="flex items-center gap-2 text-sm">
                    @if (request('brand'))
                        <input type="hidden" name="brand" value="{{ request('brand') }}">
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
                    <p>No products found in this category yet.</p>
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
