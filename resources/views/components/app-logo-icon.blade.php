@props([
    'alt' => config('app.name', 'Laravel'),
])

<img
    src="{{ asset('images/profile.png') }}"
    alt="{{ $alt }}"
    {{ $attributes->merge(['class' => 'h-full w-full rounded-md object-cover']) }}
>
