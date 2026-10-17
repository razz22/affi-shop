@props(['title', 'subtitle' => null, 'products', 'viewAllRoute' => null, 'icon' => null])

@if ($products->isNotEmpty())
<section class="container-shop py-8">
    <div class="mb-4 flex items-end justify-between gap-4">
        <div>
            <h2 class="section-title">
                @if ($icon) <i class="fa-solid {{ $icon }} text-brand"></i> @endif
                {{ $title }}
            </h2>
            @if ($subtitle)
                <p class="mt-0.5 text-sm text-slate-500">{{ $subtitle }}</p>
            @endif
        </div>

        <div class="flex items-center gap-2">
            @if ($viewAllRoute)
                <a href="{{ $viewAllRoute }}" class="hidden text-sm font-semibold text-brand-dark hover:underline sm:inline">
                    View all <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            @endif
            <button type="button" data-scroll-target="#rail-{{ Str::slug($title) }}" data-scroll-dir="left"
                    class="hidden h-9 w-9 items-center justify-center rounded-full border border-slate-300 bg-white hover:bg-slate-100 sm:flex">
                <i class="fa-solid fa-chevron-left text-xs"></i>
            </button>
            <button type="button" data-scroll-target="#rail-{{ Str::slug($title) }}" data-scroll-dir="right"
                    class="hidden h-9 w-9 items-center justify-center rounded-full border border-slate-300 bg-white hover:bg-slate-100 sm:flex">
                <i class="fa-solid fa-chevron-right text-xs"></i>
            </button>
        </div>
    </div>

    <div id="rail-{{ Str::slug($title) }}" class="scrollbar-none flex snap-x snap-mandatory gap-4 overflow-x-auto pb-2">
        @foreach ($products as $product)
            <div class="w-44 shrink-0 snap-start sm:w-52">
                <x-product-card :product="$product" />
            </div>
        @endforeach
    </div>

    @if ($viewAllRoute)
        <a href="{{ $viewAllRoute }}" class="mt-3 block text-center text-sm font-semibold text-brand-dark hover:underline sm:hidden">
            View all <i class="fa-solid fa-arrow-right text-xs"></i>
        </a>
    @endif
</section>
@endif
