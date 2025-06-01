@props(['title' => null, 'description' => null])

<x-layouts.public :title="$title" :description="$description">
    {{ $slot }}
</x-layouts.public> 