@extends('layouts.app')

@section('title', $title)

@section('content')
<div class="container-shop py-8">
    <nav class="mb-4 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a> /
        <span class="text-slate-700">{{ $title }}</span>
    </nav>

    <div class="mb-6">
        <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $title }}</h1>
        @if (! empty($subtitle))
            <p class="mt-1 text-sm text-slate-500">{{ $subtitle }}</p>
        @endif
        <p class="mt-1 text-sm text-slate-400">{{ $products->total() }} products</p>
    </div>

    <div class="mb-4 flex justify-end">
        <form method="GET" class="flex items-center gap-2 text-sm">
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
            <p>Nothing here yet &mdash; check back soon.</p>
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
@endsection
