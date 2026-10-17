@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-6">
    @php
        $cards = [
            ['label' => 'Products', 'value' => $stats['products'], 'icon' => 'fa-box', 'route' => 'admin.products.index'],
            ['label' => 'Categories', 'value' => $stats['categories'], 'icon' => 'fa-grip', 'route' => 'admin.categories.index'],
            ['label' => 'Brands', 'value' => $stats['brands'], 'icon' => 'fa-award', 'route' => 'admin.brands.index'],
            ['label' => 'Banners', 'value' => $stats['banners'], 'icon' => 'fa-images', 'route' => 'admin.banners.index'],
            ['label' => 'Total Views', 'value' => number_format($stats['views']), 'icon' => 'fa-eye', 'route' => null],
            ['label' => 'Affiliate Clicks', 'value' => number_format($stats['clicks']), 'icon' => 'fa-arrow-up-right-from-square', 'route' => null],
        ];
    @endphp
    @foreach ($cards as $card)
        <a href="{{ $card['route'] ? route($card['route']) : '#' }}" class="card flex flex-col gap-2 p-4">
            <i class="fa-solid {{ $card['icon'] }} text-brand"></i>
            <span class="text-2xl font-extrabold text-navy-900">{{ $card['value'] }}</span>
            <span class="text-xs font-semibold text-slate-500">{{ $card['label'] }}</span>
        </a>
    @endforeach
</div>

<div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="card p-5">
        <h2 class="mb-4 text-sm font-bold text-navy-900">Top Clicked Products</h2>
        <ul class="divide-y divide-slate-100">
            @forelse ($topClicked as $product)
                <li class="flex items-center justify-between gap-3 py-2.5 text-sm">
                    <a href="{{ route('admin.products.edit', $product) }}" class="truncate hover:text-brand-dark">{{ $product->name }}</a>
                    <span class="shrink-0 font-semibold text-brand-dark">{{ number_format($product->clicks) }} clicks</span>
                </li>
            @empty
                <li class="py-4 text-sm text-slate-400">No data yet.</li>
            @endforelse
        </ul>
    </div>

    <div class="card p-5">
        <h2 class="mb-4 text-sm font-bold text-navy-900">Recently Added Products</h2>
        <ul class="divide-y divide-slate-100">
            @forelse ($recentProducts as $product)
                <li class="flex items-center justify-between gap-3 py-2.5 text-sm">
                    <a href="{{ route('admin.products.edit', $product) }}" class="truncate hover:text-brand-dark">{{ $product->name }}</a>
                    <span class="shrink-0 text-xs text-slate-400">{{ $product->created_at->diffForHumans() }}</span>
                </li>
            @empty
                <li class="py-4 text-sm text-slate-400">No products yet.</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
