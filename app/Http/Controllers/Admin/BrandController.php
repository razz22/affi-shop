<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::withCount('products')->ordered()->get();

        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.form', ['brand' => new Brand]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Brand::generateUniqueSlug($data['name']);

        if ($request->hasFile('logo_file')) {
            $data['logo'] = $request->file('logo_file')->store('brands', 'public');
        }

        Brand::create($data);

        return redirect()->route('admin.brands.index')->with('status', 'Brand created successfully.');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.form', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $this->validated($request);

        if ($data['name'] !== $brand->name) {
            $data['slug'] = Brand::generateUniqueSlug($data['name'], $brand->id);
        }

        if ($request->hasFile('logo_file')) {
            if ($brand->logo && ! str_starts_with($brand->logo, 'http')) {
                Storage::disk('public')->delete($brand->logo);
            }
            $data['logo'] = $request->file('logo_file')->store('brands', 'public');
        }

        $brand->update($data);

        return redirect()->route('admin.brands.index')->with('status', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        if ($brand->logo && ! str_starts_with($brand->logo, 'http')) {
            Storage::disk('public')->delete($brand->logo);
        }

        $brand->delete();

        return redirect()->route('admin.brands.index')->with('status', 'Brand deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'description' => ['nullable', 'string', 'max:255'],
            'logo_file' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer'],
        ]);

        $data['is_featured'] = $request->boolean('is_featured');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        return $data;
    }
}
