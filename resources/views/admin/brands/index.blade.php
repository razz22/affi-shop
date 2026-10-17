@extends('layouts.admin')

@section('title', 'Brands')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <p class="text-sm text-slate-500">{{ $brands->count() }} brands</p>
    <a href="{{ route('admin.brands.create') }}" class="btn-brand"><i class="fa-solid fa-plus"></i> Add Brand</a>
</div>

<div class="card overflow-x-auto">
    <table class="w-full text-left text-sm">
        <thead class="bg-slate-50 text-xs uppercase tracking-wide text-slate-500">
            <tr>
                <th class="px-4 py-3">Logo</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Products</th>
                <th class="px-4 py-3">Featured</th>
                <th class="px-4 py-3">Order</th>
                <th class="px-4 py-3 text-right">Actions</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($brands as $brand)
                <tr>
                    <td class="px-4 py-3">
                        <div class="flex h-10 w-16 items-center justify-center rounded-lg bg-slate-50">
                            @if ($brand->image_url)
                                <img src="{{ $brand->image_url }}" class="max-h-8 max-w-full object-contain" alt="">
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $brand->name }}</td>
                    <td class="px-4 py-3 text-slate-500">{{ $brand->products_count }}</td>
                    <td class="px-4 py-3">
                        @if ($brand->is_featured)
                            <span class="badge-new">Featured</span>
                        @else
                            <span class="text-slate-300">&mdash;</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-slate-500">{{ $brand->sort_order }}</td>
                    <td class="px-4 py-3">
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="text-slate-500 hover:text-brand-dark"><i class="fa-solid fa-pen"></i></a>
                            <form method="POST" action="{{ route('admin.brands.destroy', $brand) }}" onsubmit="return confirm('Delete this brand? Products under it will not be deleted, only unlinked.');">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-slate-500 hover:text-deal"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="px-4 py-8 text-center text-slate-400">No brands yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
