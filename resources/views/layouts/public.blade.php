<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'PrimoIT') }} - {{ $title ?? 'Quality IT Hardware' }}</title>
    <meta name="description" content="{{ $description ?? 'PrimoIT offers premium refurbished IT hardware including laptops, desktops, and servers. Our quality products are perfect for businesses looking for reliable IT equipment at competitive prices.' }}">

    <!-- Favicon -->
    <x-favicon />
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    
    <!-- Critical CSS -->
    <link href="{{ asset('css/critical.css') }}" rel="stylesheet">
    
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Critical CSS -->
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            color: #333;
            line-height: 1.6;
        }
        
        .bg-primary {
            background-color: #0f2b46 !important; /* Blu più profondo simile a Return Trading */
        }
        
        .text-white {
            color: #ffffff !important;
        }
        
        /* Header styles */
        header {
            background-color: #0f2b46 !important;
            color: #ffffff !important;
            border-bottom: 1px solid #081b2e;
        }
        
        /* Top bar */
        .top-bar {
            background-color: #081b2e;
            padding: 8px 0;
            font-size: 14px;
            border-bottom: 1px solid #0f2b46;
            color: #fff;
        }
        
        /* Navigation links */
        header a {
            color: #ffffff !important;
            font-weight: 500;
        }
        
        header a:hover {
            color: #cbd5e0 !important;
        }
        
        .nav-link {
            display: inline-block;
            padding: 1.25rem 0.85rem;
            font-size: 15px;
            font-weight: 500;
            text-transform: none;
            color: #ffffff;
            border-bottom: 3px solid transparent;
            transition: all 0.2s ease;
            margin: 0 0.25rem;
        }
        
        .nav-link:hover, .nav-link.active {
            color: #ffffff;
            border-bottom: 3px solid #ffffff;
        }
        
        .stock-button {
            background-color: #ffffff;
            color: #0f2b46 !important;
            padding: 0.5rem 1.5rem;
            border-radius: 3px;
            font-weight: 500;
            transition: all 0.2s ease;
            text-transform: none;
            letter-spacing: 0.3px;
        }
        
        .stock-button:hover {
            background-color: #e2e8f0;
            color: #0f2b46 !important;
        }
        
        /* Call to action buttons */
        .btn-primary {
            background-color: #0f2b46;
            color: white;
            border-radius: 3px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: background-color 0.2s;
        }
        
        .btn-primary:hover {
            background-color: #081b2e;
        }
        
        .btn-outline {
            background-color: transparent;
            color: #0f2b46;
            border: 1px solid #0f2b46;
            border-radius: 3px;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            transition: all 0.2s;
        }
        
        .btn-outline:hover {
            background-color: #0f2b46;
            color: white;
        }
        
        /* Mobile menu styles */
        @media (max-width: 768px) {
            .md\:flex {
                display: none;
            }
            
            .md\:hidden {
                display: block;
            }
            
            .nav-link {
                padding: 1rem;
                display: block;
                border-bottom: 1px solid #eaeaea;
                margin: 0;
            }
        }
        
        @media (min-width: 769px) {
            .md\:hidden {
                display: none;
            }
            
            .md\:flex {
                display: flex;
            }
        }
        
        /* Fill for SVG icons */
        .fill-current {
            fill: currentColor;
        }
        
        /* Remove loading spinner and prevent infinite loading */
        #nprogress, .nprogress, .loading, .loader, [class*='loader'], 
        [class*='loading'], [class*='spinner'], [class*='progress'] {
            display: none !important;
            animation: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
        
        /* Hide broken images and add placeholders */
        img[src=""], img:not([src]), img[src$="undefined"] {
            visibility: hidden;
            position: relative;
        }
        
        /* Image placeholder styles */
        img {
            min-height: 30px;
            background-color: #edf2f7;
            position: relative;
        }
        
        /* Stop all animations */
        .animate-spin, .animate-pulse, .spinner, .loading, [class*='spinner'], 
        [class*='loading'], [class*='animate-'] {
            animation: none !important;
            transition: none !important;
        }
        
        /* Stop any infinite HTTP requests */
        .infinite-loading, .infinite-scroll, [class*='infinite-'] {
            display: none !important;
        }
        
        /* Logo styles */
        .logo-container {
            height: 60px;
            display: flex;
            align-items: center;
        }
        
        .logo-image {
            height: 50px;
            width: auto;
            object-fit: contain;
            max-width: 100%;
        }
        
        /* Section styling */
        .section-title {
            font-size: 2rem;
            font-weight: 700;
            color: #0f2b46;
            margin-bottom: 1.5rem;
        }
        
        .section-subtitle {
            font-size: 1.1rem;
            color: #555;
            max-width: 700px;
            margin: 0 auto 2rem;
            line-height: 1.6;
        }
        
        /* Card styling */
        .card {
            background-color: white;
            border-radius: 6px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: transform 0.2s, box-shadow 0.2s;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.12);
        }
        
        /* Footer styling */
        footer {
            background-color: #0f2b46 !important;
        }
        
        .footer-heading {
            color: white;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        
        .footer-link {
            color: #cbd5e0;
            transition: color 0.2s;
            font-size: 15px;
            display: block;
            margin-bottom: 0.5rem;
        }
        
        .footer-link:hover {
            color: white;
        }
        
        /* WhatsApp button */
        .whatsapp-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            width: 60px;
            height: 60px;
            background-color: #25D366;
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            z-index: 1000;
            transition: all 0.2s;
        }
        
        .whatsapp-button:hover {
            transform: scale(1.1);
            box-shadow: 0 3px 7px rgba(0,0,0,0.25);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen flex flex-col">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div class="flex items-center">
                        <a href="tel:+39123456789" class="flex items-center text-gray-100 hover:text-white">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            +39 123 456 789
                        </a>
                    </div>
                    <div class="flex items-center space-x-4">
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                        <a href="{{ route('register.b2b') }}" class="text-gray-600 hover:text-gray-900">Registrazione B2B</a>
                    </div>
                </div>
            </div>
        </div>

        <header class="shadow-sm">
            <div class="max-w-7xl mx-auto">
                <div class="flex justify-between items-center py-4 px-4 sm:px-6 lg:px-8">
                    <!-- Logo -->
                    <div class="flex-shrink-0">
                        <a href="{{ route('home') }}" class="flex items-center">
                            <div class="logo-container">
                                <img src="{{ asset('images/logo/primoit-logo-transparent.svg') }}" alt="PrimoIT Logo" class="logo-image" width="auto" height="50" style="background: transparent; filter: brightness(0) invert(1);" onerror="this.src='{{ asset('images/logo/primoit-logo.png') }}'; this.style.filter='brightness(0) invert(1)';">
                            </div>
                        </a>
                    </div>

                    <!-- Main Navigation -->
                    <nav class="hidden md:flex md:space-x-2 items-center">
                        <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                        <a href="{{ route('batches.index') }}" class="nav-link {{ request()->routeIs('batches.*') ? 'active' : '' }}">Available Stock</a>
                        <a href="{{ route('batches.index') }}?status=sold" class="nav-link {{ request()->is('batches*') && request()->query('status') === 'sold' ? 'active' : '' }}">Sold Stock</a>
                        <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                        <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                        <a href="{{ route('batches.index') }}" class="stock-button ml-4">Available stock</a>
                    </nav>

                    <!-- Mobile menu button -->
                    <div class="md:hidden flex items-center">
                        <button type="button" class="mobile-menu-button text-gray-700 hover:text-gray-900 focus:outline-none p-2" aria-label="Toggle menu">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Menu -->
            <div class="mobile-menu hidden md:hidden border-t border-gray-200">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
                    <a href="{{ route('batches.index') }}" class="nav-link {{ request()->routeIs('batches.*') ? 'active' : '' }}">Available Stock</a>
                    <a href="{{ route('batches.index') }}?status=sold" class="nav-link {{ request()->is('batches*') && request()->query('status') === 'sold' ? 'active' : '' }}">Sold Stock</a>
                    <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
                    <a href="{{ route('contact') }}" class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Contact</a>
                    <a href="{{ route('batches.index') }}" class="stock-button block text-center mx-2 my-4 py-2">Available stock</a>
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-grow">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer class="bg-primary text-white">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <!-- Logo and Info -->
                    <div class="col-span-1">
                        <div class="flex items-center mb-4">
                            <div class="bg-white p-2 rounded">
                                <img src="{{ asset('images/logo/primoit-logo-transparent.svg') }}" alt="PrimoIT Logo" class="h-10 w-auto" onerror="this.src='{{ asset('images/logo/primoit-logo.png') }}'">
                            </div>
                        </div>
                        <p class="text-gray-300 mb-4 max-w-md">
                            PrimoIT is a global wholesale import and export company. All prices are excl. VAT.
                        </p>
                    </div>

                    <!-- Menu Links -->
                    <div>
                        <h3 class="footer-heading">Menu</h3>
                        <ul class="space-y-2">
                            <li><a href="{{ route('home') }}" class="footer-link">Home</a></li>
                            <li><a href="{{ route('about') }}" class="footer-link">About us</a></li>
                            <li><a href="{{ route('batches.index') }}" class="footer-link">Available stock</a></li>
                            <li><a href="{{ route('contact') }}" class="footer-link">Contact</a></li>
                        </ul>
                    </div>

                    <!-- Contact Info -->
                    <div>
                        <h3 class="footer-heading">Contact</h3>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <a href="tel:+39123456789" class="text-gray-300 hover:text-white">+39 123 456 789</a>
                            </li>
                            <li class="flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-300 mr-2 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                <a href="mailto:info@primoit.com" class="text-gray-300 hover:text-white">info@primoit.com</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Bottom Footer -->
                <div class="mt-8 border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center">
                    <p class="text-base text-gray-300">&copy; {{ date('Y') }} PrimoIT. All rights reserved.</p>
                    <div class="mt-4 md:mt-0 flex space-x-6">
                        <a href="{{ route('terms') }}" class="text-sm text-gray-300 hover:text-white">Terms</a>
                        <a href="{{ route('privacy') }}" class="text-sm text-gray-300 hover:text-white">Privacy</a>
                    </div>
                </div>
            </div>
        </footer>
    </div>

    <!-- WhatsApp Button -->
    <a href="https://wa.me/39123456789" class="whatsapp-button" target="_blank" aria-label="Contact us on WhatsApp">
        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="currentColor">
            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
        </svg>
    </a>

    <script src="{{ asset('js/image-handler.js') }}"></script>
    <script>
        // Mobile menu toggle
        document.addEventListener('DOMContentLoaded', function() {
            // Toggle mobile menu
            const mobileMenuButton = document.querySelector('.mobile-menu-button');
            const mobileMenu = document.querySelector('.mobile-menu');
            
            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    mobileMenu.classList.toggle('hidden');
                });
            }
        });
    </script>
</body>
</html> 