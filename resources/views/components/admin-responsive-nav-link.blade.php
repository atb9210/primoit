@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-3 py-2 bg-red-600 text-start text-base font-medium text-white focus:outline-none focus:text-white focus:bg-red-700 transition duration-150 ease-in-out'
    : 'block w-full px-3 py-2 bg-white text-start text-base font-medium text-red-600 hover:bg-gray-100 hover:text-red-700 focus:outline-none focus:text-red-700 focus:bg-gray-100 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> 