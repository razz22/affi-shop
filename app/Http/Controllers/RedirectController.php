<?php

namespace App\Http\Controllers;

use App\Models\Product;

class RedirectController extends Controller
{
    public function go(Product $product)
    {
        abort_unless($product->status, 404);

        $product->increment('clicks');

        return redirect()->away($product->affiliate_link);
    }
}
