@props(['active'])

@php
$classes = ($active ?? false)
    ? 'inline-flex items-center px-3 py-2 bg-red-600 rounded-md text-sm font-medium leading-5 text-white focus:outline-none focus:bg-red-700 transition duration-150 ease-in-out'
    : 'inline-flex items-center px-3 py-2 text-sm font-medium leading-5 text-white hover:text-gray-200 hover:bg-gray-700 focus:outline-none focus:text-white focus:bg-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>