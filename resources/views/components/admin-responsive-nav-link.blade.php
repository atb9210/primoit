@props(['active'])

@php
$classes = ($active ?? false)
    ? 'block w-full px-3 py-2 bg-red-600 text-start text-base font-medium text-white focus:outline-none focus:text-white focus:bg-red-700 transition duration-150 ease-in-out'
    : 'block w-full px-3 py-2 text-start text-base font-medium text-white hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 focus:border-gray-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a> 