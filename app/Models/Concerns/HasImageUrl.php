<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;

trait HasImageUrl
{
    public function getImageUrlAttribute(): ?string
    {
        $column = $this->imageColumn ?? 'image';
        $path = $this->attributes[$column] ?? null;

        if (! $path) {
            return null;
        }

        return str_starts_with($path, 'http') ? $path : Storage::disk('public')->url($path);
    }
}
