@props(['rating' => 0, 'count' => null, 'size' => 'sm'])

@php
    $rating = (float) $rating;
    $full = floor($rating);
    $half = ($rating - $full) >= 0.5;
    $textSize = $size === 'lg' ? 'text-base' : 'text-xs';
@endphp

<div class="flex items-center gap-1 {{ $textSize }}">
    <div class="flex text-brand">
        @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $full)
                <i class="fa-solid fa-star"></i>
            @elseif ($half && $i === $full + 1)
                <i class="fa-solid fa-star-half-stroke"></i>
            @else
                <i class="fa-regular fa-star text-slate-300"></i>
            @endif
        @endfor
    </div>
    @if (! is_null($count))
        <span class="text-slate-500">({{ number_format($count) }})</span>
    @endif
</div>
