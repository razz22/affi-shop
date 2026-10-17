@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Category' : 'Add Category')

@section('content')
<div class="max-w-xl">
    <form method="POST"
          action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}"
          enctype="multipart/form-data" class="card space-y-5 p-6">
        @csrf
        @if ($category->exists) @method('PUT') @endif

        <div>
            <label for="name" class="label">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" required class="input">
        </div>

        <div>
            <label for="description" class="label">Description (optional)</label>
            <textarea name="description" id="description" rows="2" class="input">{{ old('description', $category->description) }}</textarea>
        </div>

        <div>
            <label for="icon" class="label">Icon class (Font Awesome, optional)</label>
            <input type="text" name="icon" id="icon" value="{{ old('icon', $category->icon) }}" placeholder="fa-mobile-alt" class="input">
        </div>

        <div>
            <label class="label">Image</label>
            @if ($category->image_url)
                <img src="{{ $category->image_url }}" class="mb-2 h-20 w-20 rounded-lg object-cover">
            @endif
            <input type="file" name="image_file" accept="image/*" class="input">
            <p class="mt-1 text-xs text-slate-400">{{ $category->exists ? 'Leave empty to keep current image.' : 'Recommended: square image, at least 400x400.' }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="sort_order" class="label">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $category->sort_order) }}" class="input">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $category->is_featured)) class="rounded border-slate-300">
                    Show on homepage
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-brand"><i class="fa-solid fa-floppy-disk"></i> Save Category</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
