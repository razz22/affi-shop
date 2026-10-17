@extends('layouts.app')

@section('title', 'Search results for "'.$term.'"')

@section('content')
<div class="container-shop py-8">
    <h1 class="text-2xl font-extrabold text-navy-900 sm:text-3xl">
        @if ($term !== '')
            Search results for &ldquo;{{ $term }}&rdquo;
        @else
            Search
        @endif
    </h1>
    <p class="mt-1 text-sm text-slate-400">{{ $products->total() }} products found</p>

    @if ($products->isEmpty())
        <div class="card mt-6 p-10 text-center text-slate-400">
            <i class="fa-solid fa-magnifying-glass mb-3 text-4xl"></i>
            <p>No products matched your search. Try a different keyword.</p>
        </div>
    @else
        <div class="mt-6 grid grid-cols-2 gap-4 sm:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        <div class="mt-8">{{ $products->links() }}</div>
    @endif
</div>
@endsection
