<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

trait FiltersProducts
{
    protected function applyBrandFilter(Builder|Relation $query, Request $request): Builder|Relation
    {
        if ($slug = $request->get('brand')) {
            $query->whereHas('brand', fn ($q) => $q->where('slug', $slug));
        }

        return $query;
    }

    protected function applySort(Builder|Relation $query, Request $request): Builder|Relation
    {
        return match ($request->get('sort')) {
            'price_low' => $query->orderBy(DB::raw('COALESCE(discount_price, price)')),
            'price_high' => $query->orderByDesc(DB::raw('COALESCE(discount_price, price)')),
            'rating' => $query->orderByDesc('rating'),
            'newest' => $query->latest(),
            default => $query->orderByDesc('rating_count'),
        };
    }
}
