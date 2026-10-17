@props(['product'])

<div class="card group relative flex h-full flex-col overflow-hidden">
    @if ($product->badge || $product->has_discount)
        <div class="absolute left-2 top-2 z-10 flex flex-col gap-1">
            @if ($product->has_discount)
                <span class="badge-deal shadow">-{{ $product->discount_percent }}%</span>
            @endif
            @if ($product->badge)
                <span class="badge-choice shadow">{{ $product->badge }}</span>
            @endif
        </div>
    @endif

    <a href="{{ route('product.show', $product) }}" class="block aspect-square shrink-0 overflow-hidden bg-slate-50">
        @if ($product->primary_image_url)
            <img src="{{ $product->primary_image_url }}" alt="{{ $product->name }}" loading="lazy"
                 class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
        @else
            <div class="flex h-full w-full items-center justify-center text-slate-300">
                <i class="fa-solid fa-image text-4xl"></i>
            </div>
        @endif
    </a>

    <div class="flex flex-1 flex-col gap-1.5 p-3.5">
        <span class="block h-4 text-xs font-semibold uppercase tracking-wide text-slate-400">
            {{ $product->brand->name ?? '' }}
        </span>

        <a href="{{ route('product.show', $product) }}" class="line-clamp-2 min-h-[2.5rem] text-sm font-semibold text-slate-800 hover:text-brand-dark">
            {{ $product->name }}
        </a>

        <x-star-rating :rating="$product->rating" :count="$product->rating_count" />

        <div class="mt-1 flex items-baseline gap-2">
            <span class="price-current">${{ number_format($product->final_price, 2) }}</span>
            @if ($product->has_discount)
                <span class="price-old">${{ number_format($product->price, 2) }}</span>
            @endif
        </div>
        <span class="block h-4 text-xs font-semibold text-success">
            @if ($product->has_discount)
                You save ${{ number_format($product->savings, 2) }}
            @endif
        </span>

        <a href="{{ route('go', $product) }}" target="_blank" rel="nofollow sponsored noopener"
           class="btn-brand mt-auto w-full text-xs">
            <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Store
        </a>
    </div>
</div>
