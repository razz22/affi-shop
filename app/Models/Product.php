<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'brand_id', 'name', 'slug', 'sku',
        'short_description', 'description', 'price', 'discount_price',
        'affiliate_link', 'badge', 'rating', 'rating_count', 'stock_status',
        'is_featured', 'is_bestseller', 'is_deal', 'is_gift_card', 'is_new',
        'status', 'views', 'clicks',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'rating' => 'decimal:1',
        'is_featured' => 'boolean',
        'is_bestseller' => 'boolean',
        'is_deal' => 'boolean',
        'is_gift_card' => 'boolean',
        'is_new' => 'boolean',
        'status' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    public function getPrimaryImageUrlAttribute(): ?string
    {
        $primary = $this->images->firstWhere('is_primary', true) ?? $this->images->first();

        return $primary?->image_url;
    }

    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->discount_price ?? $this->price);
    }

    public function getHasDiscountAttribute(): bool
    {
        return $this->discount_price !== null && (float) $this->discount_price < (float) $this->price;
    }

    public function getDiscountPercentAttribute(): int
    {
        if (! $this->has_discount || (float) $this->price <= 0) {
            return 0;
        }

        return (int) round((((float) $this->price - (float) $this->discount_price) / (float) $this->price) * 100);
    }

    public function getSavingsAttribute(): float
    {
        return $this->has_discount ? round((float) $this->price - (float) $this->discount_price, 2) : 0;
    }

    public static function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $slug = Str::slug($name);
        $original = $slug;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$original}-{$i}";
            $i++;
        }

        return $slug;
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeBestseller($query)
    {
        return $query->where('is_bestseller', true);
    }

    public function scopeDeal($query)
    {
        return $query->where('is_deal', true);
    }

    public function scopeGiftCard($query)
    {
        return $query->where('is_gift_card', true);
    }

    public function scopeNewArrival($query)
    {
        return $query->where('is_new', true);
    }

    public function scopePopular($query)
    {
        return $query->orderByDesc('rating_count');
    }
}
