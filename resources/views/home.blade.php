@extends('layouts.app')

@section('title', 'Home')

@section('content')

    {{-- Hero banner slider --}}
    @if ($banners->isNotEmpty())
        <section id="hero-slider" class="relative h-[320px] w-full overflow-hidden sm:h-[420px] lg:h-[480px]">
            @foreach ($banners as $i => $banner)
                <a href="{{ $banner->link }}" target="_blank" rel="nofollow sponsored noopener"
                   data-slide
                   class="absolute inset-0 flex items-center transition-opacity duration-700 {{ $i === 0 ? 'opacity-100' : 'opacity-0' }}"
                   style="background-image: linear-gradient(90deg, {{ $banner->bg_color }}ee 10%, {{ $banner->bg_color }}55 55%, transparent 100%), url('{{ $banner->image_url }}'); background-size: cover; background-position: center;">
                    <div class="container-shop">
                        <div class="max-w-lg text-white text-shadow">
                            <h1 class="text-3xl font-extrabold sm:text-4xl lg:text-5xl">{{ $banner->title }}</h1>
                            @if ($banner->subtitle)
                                <p class="mt-3 text-base text-slate-100 sm:text-lg">{{ $banner->subtitle }}</p>
                            @endif
                            <span class="btn-brand mt-6 inline-flex">
                                {{ $banner->button_text }} <i class="fa-solid fa-arrow-right"></i>
                            </span>
                        </div>
                    </div>
                </a>
            @endforeach

            @if ($banners->count() > 1)
                <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
                    @foreach ($banners as $i => $banner)
                        <button type="button" data-dot class="h-2.5 w-2.5 rounded-full {{ $i === 0 ? 'bg-white' : 'bg-white/40' }}"></button>
                    @endforeach
                </div>
            @endif
        </section>
    @endif

    {{-- Shop by category --}}
    @if ($categories->isNotEmpty())
        <section class="container-shop py-8">
            <h2 class="section-title mb-4"><i class="fa-solid fa-grip text-brand"></i> Shop by Category</h2>
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-5">
                @foreach ($categories as $category)
                    <a href="{{ route('category.show', $category) }}" class="card group flex flex-col items-center gap-2 p-4 text-center">
                        <div class="h-20 w-20 overflow-hidden rounded-full bg-slate-100 sm:h-24 sm:w-24">
                            @if ($category->image_url)
                                <img src="{{ $category->image_url }}" alt="{{ $category->name }}" loading="lazy"
                                     class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-slate-700 group-hover:text-brand-dark">{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </section>
    @endif

    <x-product-rail title="Today's Deals" subtitle="Grab them before they're gone" icon="fa-bolt"
                     :products="$deals" :view-all-route="route('deals')" />

    {{-- Brand strip --}}
    @if ($brands->isNotEmpty())
        <section class="bg-white py-8">
            <div class="container-shop">
                <h2 class="section-title mb-4"><i class="fa-solid fa-award text-brand"></i> Shop by Brand</h2>
                <div class="scrollbar-none flex gap-4 overflow-x-auto pb-2">
                    @foreach ($brands as $brand)
                        <a href="{{ route('brand.show', $brand) }}"
                           class="card flex h-20 w-36 shrink-0 items-center justify-center p-4">
                            @if ($brand->image_url)
                                <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" loading="lazy" class="max-h-8 max-w-full object-contain">
                            @else
                                <span class="font-bold text-slate-700">{{ $brand->name }}</span>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <x-product-rail title="Best Sellers" subtitle="Customer favorites, again and again" icon="fa-crown"
                     :products="$bestSellers" :view-all-route="route('bestsellers')" />

    <x-product-rail title="Popular Right Now" subtitle="Trending across every category" icon="fa-fire"
                     :products="$popular" :view-all-route="route('popular')" />

    {{-- Gift cards banner strip --}}
    @if ($giftCards->isNotEmpty())
        <section class="py-8">
            <div class="container-shop">
                <div class="overflow-hidden rounded-2xl bg-gradient-to-r from-navy-900 to-navy-700 p-6 text-white sm:p-10">
                    <div class="flex flex-col items-start justify-between gap-6 sm:flex-row sm:items-center">
                        <div>
                            <h2 class="text-2xl font-extrabold sm:text-3xl"><i class="fa-solid fa-gift text-brand"></i> Gift Cards for Every Occasion</h2>
                            <p class="mt-2 max-w-xl text-slate-300">Instant delivery, zero hassle &mdash; the easiest way to give exactly what they want.</p>
                        </div>
                        <a href="{{ route('gift-cards') }}" class="btn-brand shrink-0">Browse Gift Cards <i class="fa-solid fa-arrow-right"></i></a>
                    </div>
                    <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-4">
                        @foreach ($giftCards as $card)
                            <a href="{{ route('product.show', $card) }}" class="rounded-xl bg-white/10 p-4 text-center backdrop-blur transition hover:bg-white/20">
                                <p class="text-lg font-bold">${{ number_format($card->price, 0) }}</p>
                                <p class="text-xs text-slate-300">Gift Card</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <x-product-rail title="New Arrivals" subtitle="Fresh finds just added" icon="fa-sparkles"
                     :products="$newArrivals" :view-all-route="route('new-arrivals')" />

    <x-product-rail title="Featured Picks" subtitle="Hand-picked recommendations from our team" icon="fa-star"
                     :products="$featured" />

@endsection
