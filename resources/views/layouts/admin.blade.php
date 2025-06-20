<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'PrimoIT') }} - Admin Panel</title>

        <!-- Favicon -->
        <x-favicon />
        
        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Fallback per Tailwind CSS se Vite non funziona -->
        <script>
            // Controlla se lo stile Tailwind è stato caricato
            window.addEventListener('DOMContentLoaded', (event) => {
                setTimeout(() => {
                    const checkTailwind = getComputedStyle(document.documentElement).getPropertyValue('--tw-ring-offset-width');
                    if (!checkTailwind) {
                        // Se Tailwind non è caricato, carica da CDN
                        const link = document.createElement('link');
                        link.href = 'https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css';
                        link.rel = 'stylesheet';
                        document.head.appendChild(link);
                        console.log('Tailwind CSS caricato da CDN come fallback');
                    }
                }, 300);
            });
        </script>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.admin-navigation')

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html> 