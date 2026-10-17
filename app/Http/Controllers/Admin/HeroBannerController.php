<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroBanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroBannerController extends Controller
{
    public function index()
    {
        $banners = HeroBanner::ordered()->get();

        return view('admin.banners.index', compact('banners'));
    }

    public function create()
    {
        return view('admin.banners.form', ['banner' => new HeroBanner]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request, true);

        $data['image'] = $request->file('image_file')->store('banners', 'public');

        HeroBanner::create($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner created successfully.');
    }

    public function edit(HeroBanner $banner)
    {
        return view('admin.banners.form', compact('banner'));
    }

    public function update(Request $request, HeroBanner $banner)
    {
        $data = $this->validated($request, false);

        if ($request->hasFile('image_file')) {
            if ($banner->image && ! str_starts_with($banner->image, 'http')) {
                Storage::disk('public')->delete($banner->image);
            }
            $data['image'] = $request->file('image_file')->store('banners', 'public');
        }

        $banner->update($data);

        return redirect()->route('admin.banners.index')->with('status', 'Banner updated successfully.');
    }

    public function destroy(HeroBanner $banner)
    {
        if ($banner->image && ! str_starts_with($banner->image, 'http')) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('admin.banners.index')->with('status', 'Banner deleted.');
    }

    private function validated(Request $request, bool $imageRequired): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'link' => ['required', 'url', 'max:1000'],
            'button_text' => ['nullable', 'string', 'max:60'],
            'bg_color' => ['nullable', 'string', 'max:20'],
            'sort_order' => ['nullable', 'integer'],
            'image_file' => [$imageRequired ? 'required' : 'nullable', 'image', 'max:4096'],
        ]);

        $data['button_text'] = $data['button_text'] ?? 'Shop Now';
        $data['bg_color'] = $data['bg_color'] ?? '#232f3e';
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }
}
