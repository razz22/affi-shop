@extends('layouts.app')

@section('title', $product->name)
@section('meta_description', $product->short_description)

@section('content')
<div class="container-shop py-8">

    <nav class="mb-4 text-xs text-slate-500">
        <a href="{{ route('home') }}" class="hover:text-brand-dark">Home</a> /
        @if ($product->category)
            <a href="{{ route('category.show', $product->category) }}" class="hover:text-brand-dark">{{ $product->category->name }}</a> /
        @endif
        <span class="text-slate-700">{{ $product->name }}</span>
    </nav>

    <div class="grid grid-cols-1 gap-10 lg:grid-cols-2">
        {{-- Gallery --}}
        <div x-data="{ active: 0 }" x-cloak class="lg:sticky lg:top-24 lg:self-start">
            <div class="card aspect-square overflow-hidden bg-slate-50">
                @forelse ($product->images as $i => $image)
                    <img x-show="active === {{ $i }}" src="{{ $image->image_url }}" alt="{{ $product->name }}"
                         class="h-full w-full object-cover">
                @empty
                    <div class="flex h-full w-full items-center justify-center text-slate-300">
                        <i class="fa-solid fa-image text-6xl"></i>
                    </div>
                @endforelse
            </div>

            @if ($product->images->count() > 1)
                <div class="mt-3 flex gap-3 overflow-x-auto">
                    @foreach ($product->images as $i => $image)
                        <button type="button" @click="active = {{ $i }}"
                                :class="active === {{ $i }} ? 'border-brand' : 'border-transparent'"
                                class="h-16 w-16 shrink-0 overflow-hidden rounded-lg border-2 bg-slate-50">
                            <img src="{{ $image->image_url }}" alt="" class="h-full w-full object-cover">
                        </button>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Details --}}
        <div>
            @if ($product->brand)
                <a href="{{ route('brand.show', $product->brand) }}" class="text-sm font-semibold uppercase tracking-wide text-brand-dark hover:underline">
                    {{ $product->brand->name }}
                </a>
            @endif

            <h1 class="mt-1 text-2xl font-extrabold text-navy-900 sm:text-3xl">{{ $product->name }}</h1>

            <div class="mt-3 flex items-center gap-3">
                <x-star-rating :rating="$product->rating" :count="$product->rating_count" size="lg" />
                @if ($product->badge)
                    <span class="badge-choice">{{ $product->badge }}</span>
                @endif
            </div>

            <div class="mt-5 rounded-xl border border-slate-200 bg-slate-50 p-5">
                <div class="flex flex-wrap items-baseline gap-3">
                    <span class="text-3xl font-extrabold text-navy-900">${{ number_format($product->final_price, 2) }}</span>
                    @if ($product->has_discount)
                        <span class="text-lg text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                        <span class="badge-deal">-{{ $product->discount_percent }}% OFF</span>
                    @endif
                </div>
                @if ($product->has_discount)
                    <p class="mt-1 text-sm font-semibold text-success">You save ${{ number_format($product->savings, 2) }} ({{ $product->discount_percent }}%)</p>
                @endif

                <p class="mt-3 text-sm">
                    @if ($product->stock_status === 'in_stock')
                        <span class="font-semibold text-success"><i class="fa-solid fa-circle-check"></i> In Stock</span>
                    @elseif ($product->stock_status === 'limited')
                        <span class="font-semibold text-brand-dark"><i class="fa-solid fa-triangle-exclamation"></i> Limited Stock</span>
                    @else
                        <span class="font-semibold text-deal"><i class="fa-solid fa-circle-xmark"></i> Out of Stock</span>
                    @endif
                </p>

                <a href="{{ route('go', $product) }}" target="_blank" rel="nofollow sponsored noopener"
                   class="btn-brand mt-4 w-full py-3 text-base">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Store
                </a>
                <p class="mt-2 text-center text-xs text-slate-400">You'll be redirected to the retailer's site to complete your purchase.</p>
            </div>

            @if ($product->short_description)
                <p class="mt-5 text-slate-600">{{ $product->short_description }}</p>
            @endif

            <dl class="mt-5 grid grid-cols-2 gap-3 text-sm">
                @if ($product->sku)
                    <div><dt class="text-slate-400">SKU</dt><dd class="font-medium text-slate-700">{{ $product->sku }}</dd></div>
                @endif
                @if ($product->category)
                    <div><dt class="text-slate-400">Category</dt><dd class="font-medium text-slate-700">{{ $product->category->name }}</dd></div>
                @endif
            </dl>
        </div>
    </div>

    {{-- Full description --}}
    @if ($product->description)
        <div class="mt-12 max-w-3xl">
            <h2 class="section-title mb-3">Product Description</h2>
            <div class="rich-text">
                {!! $product->description !!}
            </div>
        </div>
    @endif

    <x-product-rail title="Related Products" subtitle="More from this category" icon="fa-layer-group" :products="$related" />

    <x-product-rail title="Customers Also Viewed" subtitle="Popular picks from other categories" icon="fa-eye" :products="$others" />

</div>
@endsection
