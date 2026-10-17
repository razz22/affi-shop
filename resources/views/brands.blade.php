@extends('layouts.app')

@section('title', 'All Brands')

@section('content')
<div class="container-shop py-8">
    <h1 class="section-title mb-6">All Brands</h1>

    <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 md:grid-cols-4">
        @foreach ($brands as $brand)
            <a href="{{ route('brand.show', $brand) }}" class="card flex flex-col items-center gap-3 p-6 text-center">
                <div class="flex h-14 w-full items-center justify-center">
                    @if ($brand->image_url)
                        <img src="{{ $brand->image_url }}" alt="{{ $brand->name }}" class="max-h-full max-w-full object-contain">
                    @else
                        <span class="text-lg font-bold text-slate-700">{{ $brand->name }}</span>
                    @endif
                </div>
                <div>
                    <p class="font-semibold text-slate-800">{{ $brand->name }}</p>
                    <p class="text-xs text-slate-400">{{ $brand->products_count }} products</p>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
