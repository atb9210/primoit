<x-public-layout>
    <x-slot name="title">Product Categories</x-slot>
    <x-slot name="description">Browse all product categories of IT hardware available at PrimoIT including laptops, desktops, servers, and accessories.</x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="max-w-7xl mx-auto text-center mb-12">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Product Categories
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Browse our selection of IT hardware by category
                </p>
            </div>

            <!-- Categories Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($categories as $category)
                <a href="{{ route('categories.show', $category) }}" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform group-hover:shadow-lg">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            @if($category->icon_image)
                                <img src="{{ asset('storage/' . $category->icon_image) }}" alt="{{ $category->name }}" class="h-full w-full object-contain">
                            @elseif($category->icon_svg)
                                <div class="h-full w-full flex items-center justify-center bg-gray-50">
                                    {!! $category->icon_svg !!}
                                </div>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            @endif
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">{{ $category->name }}</h3>
                            <p class="text-gray-600 mt-2">{{ $category->description ?? 'Browse products in this category' }}</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">{{ $category->batches_count ?? $category->batches->count() ?? 0 }} batches</span>
                                <span class="text-blue-600 text-sm font-medium group-hover:underline">View Category</span>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center py-12">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                    <p class="text-gray-500">We are currently updating our product categories.</p>
                </div>

                <!-- Placeholder categories for demo purposes -->
                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform group-hover:shadow-lg">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">Laptops</h3>
                            <p class="text-gray-600 mt-2">Business and premium laptops from top brands</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">35 products</span>
                                <span class="text-blue-600 text-sm font-medium group-hover:underline">View Category</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform group-hover:shadow-lg">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">Desktops</h3>
                            <p class="text-gray-600 mt-2">Powerful desktop computers for office use</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">28 products</span>
                                <span class="text-blue-600 text-sm font-medium group-hover:underline">View Category</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform group-hover:shadow-lg">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">Servers</h3>
                            <p class="text-gray-600 mt-2">Enterprise-grade servers for your business</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">15 products</span>
                                <span class="text-blue-600 text-sm font-medium group-hover:underline">View Category</span>
                            </div>
                        </div>
                    </div>
                </a>

                <a href="#" class="group">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden transition transform group-hover:shadow-lg">
                        <div class="h-48 bg-gray-100 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-blue-600 transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                            </svg>
                        </div>
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 group-hover:text-blue-600 transition">Accessories</h3>
                            <p class="text-gray-600 mt-2">Monitors, keyboards, docking stations and more</p>
                            <div class="flex justify-between items-center mt-4">
                                <span class="text-sm text-gray-500">42 products</span>
                                <span class="text-blue-600 text-sm font-medium group-hover:underline">View Category</span>
                            </div>
                        </div>
                    </div>
                </a>
                @endforelse
            </div>
        </div>
    </div>