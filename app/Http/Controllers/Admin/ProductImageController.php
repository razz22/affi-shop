<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);

        if (! str_starts_with($image->image, 'http')) {
            Storage::disk('public')->delete($image->image);
        }

        $wasPrimary = $image->is_primary;
        $image->delete();

        if ($wasPrimary) {
            $product->images()->orderBy('sort_order')->first()?->update(['is_primary' => true]);
        }

        return back()->with('status', 'Image removed.');
    }

    public function primary(Product $product, ProductImage $image)
    {
        abort_unless($image->product_id === $product->id, 404);

        $product->images()->update(['is_primary' => false]);
        $image->update(['is_primary' => true]);

        return back()->with('status', 'Primary image updated.');
    }
}
