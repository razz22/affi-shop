@extends('layouts.admin')

@section('title', $banner->exists ? 'Edit Banner' : 'Add Banner')

@section('content')
<div class="max-w-xl">
    <form method="POST"
          action="{{ $banner->exists ? route('admin.banners.update', $banner) : route('admin.banners.store') }}"
          enctype="multipart/form-data" class="card space-y-5 p-6">
        @csrf
        @if ($banner->exists) @method('PUT') @endif

        <div>
            <label for="title" class="label">Title</label>
            <input type="text" name="title" id="title" value="{{ old('title', $banner->title) }}" required class="input">
        </div>

        <div>
            <label for="subtitle" class="label">Subtitle (optional)</label>
            <input type="text" name="subtitle" id="subtitle" value="{{ old('subtitle', $banner->subtitle) }}" class="input">
        </div>

        <div>
            <label for="link" class="label">Affiliate / Product Link</label>
            <input type="url" name="link" id="link" value="{{ old('link', $banner->link) }}" required placeholder="https://www.amazon.com/..." class="input">
        </div>

        <div>
            <label class="label">Banner Image</label>
            @if ($banner->image_url)
                <img src="{{ $banner->image_url }}" class="mb-2 h-24 w-full rounded-lg object-cover">
            @endif
            <input type="file" name="image_file" accept="image/*" class="input" @if(!$banner->exists) required @endif>
            <p class="mt-1 text-xs text-slate-400">Recommended: wide image, at least 1600x500. {{ $banner->exists ? 'Leave empty to keep current image.' : '' }}</p>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="button_text" class="label">Button Text</label>
                <input type="text" name="button_text" id="button_text" value="{{ old('button_text', $banner->button_text ?? 'Shop Now') }}" class="input">
            </div>
            <div>
                <label for="bg_color" class="label">Overlay Color</label>
                <input type="color" name="bg_color" id="bg_color" value="{{ old('bg_color', $banner->bg_color ?? '#232f3e') }}" class="input h-10 p-1">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="sort_order" class="label">Sort Order</label>
                <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', $banner->sort_order) }}" class="input">
            </div>
            <div class="flex items-end pb-2">
                <label class="flex items-center gap-2 text-sm font-semibold text-slate-700">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $banner->exists ? $banner->is_active : true)) class="rounded border-slate-300">
                    Active
                </label>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-brand"><i class="fa-solid fa-floppy-disk"></i> Save Banner</button>
            <a href="{{ route('admin.banners.index') }}" class="btn-outline">Cancel</a>
        </div>
    </form>
</div>
@endsection
