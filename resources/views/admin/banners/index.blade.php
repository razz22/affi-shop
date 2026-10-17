@extends('layouts.admin')

@section('title', 'Hero Banners')

@section('content')
<div class="mb-4 flex items-center justify-between">
    <p class="text-sm text-slate-500">{{ $banners->count() }} banners &mdash; shown as the homepage hero slider</p>
    <a href="{{ route('admin.banners.create') }}" class="btn-brand"><i class="fa-solid fa-plus"></i> Add Banner</a>
</div>

<div class="grid grid-cols-1 gap-4 md:grid-cols-2">
    @forelse ($banners as $banner)
        <div class="card overflow-hidden">
            <div class="relative h-36 bg-slate-100">
                <img src="{{ $banner->image_url }}" class="h-full w-full object-cover" alt="">
                <div class="absolute inset-0 flex items-center bg-gradient-to-r from-black/60 to-transparent p-4">
                    <div class="text-white">
                        <p class="font-bold">{{ $banner->title }}</p>
                        <p class="text-xs text-slate-200">{{ $banner->subtitle }}</p>
                    </div>
                </div>
                @if (! $banner->is_active)
                    <span class="absolute right-2 top-2 rounded-full bg-slate-800/80 px-2 py-0.5 text-xs text-white">Hidden</span>
                @endif
            </div>
            <div class="flex items-center justify-between p-4">
                <a href="{{ $banner->link }}" target="_blank" class="truncate text-xs text-slate-400 hover:text-brand-dark">{{ $banner->link }}</a>
                <div class="flex shrink-0 gap-3">
                    <a href="{{ route('admin.banners.edit', $banner) }}" class="text-slate-500 hover:text-brand-dark"><i class="fa-solid fa-pen"></i></a>
                    <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Delete this banner?');">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-slate-500 hover:text-deal"><i class="fa-solid fa-trash"></i></button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <p class="text-slate-400">No banners yet.</p>
    @endforelse
</div>
@endsection
