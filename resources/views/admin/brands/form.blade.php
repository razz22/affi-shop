@extends('layouts.admin')

@section('title', $brand->exists ? 'Edit Brand' : 'Add Brand')

@section('content')
<div class="max-w-xl">
    <form method="POST"
          action="{{ $brand->exists ? route('admin.brands.update', $brand) : route('admin.brands.store') }}"
          enctype="multipart/form-data" class="card space-y-5 p-6">
        @csrf
        @if ($brand->exists) @method('PUT') @endif

        <div>
            <label for="name" class="label">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $brand->name) }}" required class="input">
        </div>

        <div>
            <label for="description" class="label">Description (optional)</label>
            <textarea name="description" id="description" rows="2" class="input">{{ old('description', $brand->description) }}</textarea>
        </div>

        <div>
            <label class="label">Logo</label>
            @if ($brand->image_url)
                <div class="mb-2 flex h-16 w-28 items-center justify-center rounded-lg bg-slate-50">
                    <img src="{{ $brand->image_url }}" class="max-h-10 max-w-full object-contain">
                </div>
            @endif
            <input type="file" name="logo_file" accept="image/*" class="input">
            <p class="mt-1 text-xs text-slate-400">{{ $brand->exists ? 'Leave empty to keep current logo.' : 'PNG with transparent background works best.' }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="sort_order" class="label">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $brand->sort_order) }}" class="input">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $brand->is_featured)) class="rounded border-slate-300">
                    Show on homepage
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-brand"><i class="fa-solid fa-floppy-disk"></i> Save Brand</button>
            <a href="{{ route('admin.brands.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
