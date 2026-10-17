@extends('layouts.admin')

@section('title', 'Products')

@section('content')
<div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
    <form method="GET" class="flex gap-2">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products..." class="input w-64">
        <button type="submit" class="btn-outline"><i class="fa-solid fa-magnifying-glass"></i></button>
    </form>
    <a href="{{ route('admin.products.create') }}" class="btn-brand"><i class="fa-solid fa-plus"></i> Add Product</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr>
                <th class="px-4 py-3">Product</th>
                <th class="px-4 py-3">Category</th>
                <th class="px-4 py-3">Brand</th>
                <th class="px-4 py-3">Price</th>
                <th class="px-4 py-3">Flags</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($products as $product)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 shrink-0 overflow-hidden rounded-lg bg-slate-100">
                                @if ($product->primary_image_url)
                                    <img src="{{ $product->primary_image_url }}" class="h-full w-full object-cover" alt="">
                                @endif
                            </div>
                            <span class="max-w-[220px] truncate font-semibold text-slate-800">{{ $product->name }}</span>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $product->category?->name ?? '—' }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $product->brand?->name ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="font-semibold text-slate-800">${{ number_format($product->final_price, 2) }}</span>
                        @if ($product->has_discount)
                            <span class="ml-1 text-xs text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @if ($product->is_featured) <span class="badge-choice">Featured</span> @endif
                            @if ($product->is_bestseller) <span class="badge-brand">Best</span> @endif
                            @if ($product->is_deal) <span class="badge-deal">Deal</span> @endif
                            @if ($product->is_new) <span class="badge-new">New</span> @endif
                            @if ($product->is_gift_card) <span class="badge-brand">Gift</span> @endif
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        @if ($product->status)
                            <span class="badge-new">Live</span>
                        @else
                            <span class="badge bg-slate-100 text-slate-500">Hidden</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('product.show', $product) }}" target="_blank" class="text-slate-500 hover:text-navy-900"><i class="fa-solid fa-eye"></i></a>
                            <a href="{{ route('admin.products.edit', $product) }}" class="text-slate-500 hover:text-brand-dark"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Delete this product permanently?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-deal"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="px-4 py-8 text-center text-slate-400">No products found.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">{{ $products->links() }}</div>
@endsection
