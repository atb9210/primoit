<x-public-layout>
    <x-slot name="title">Home - Premium IT Hardware</x-slot>
    <x-slot name="description">PrimoIT offers high-quality refurbished IT hardware for businesses. Browse our batches of laptops, desktops, and servers.</x-slot>

    <!-- Hero Section -->
    <section class="bg-white text-gray-900 py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center">
                <div class="md:w-1/2 mb-10 md:mb-0">
                    <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-6 text-gray-900">
                        Premium IT Hardware
                    </h1>
                    <p class="text-xl mb-8 text-gray-600 max-w-lg">
                        PrimoIT is a global wholesale import and export company. All prices are excl. VAT.
                    </p>
                    <div class="flex flex-col sm:flex-row space-y-4 sm:space-y-0 sm:space-x-4">
                        <a href="{{ route('batches.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary hover:bg-opacity-90 transition">
                            Available stock
                        </a>
                        <a href="{{ route('contact') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                            Contact us
                        </a>
                    </div>
                </div>
                <div class="md:w-1/2">
                    <img src="{{ asset('images/hero-hardware.png') }}" alt="IT Hardware" class="rounded-lg shadow-xl" onerror="this.src='{{ asset('images/fallback/hardware.svg') }}'">
                </div>
            </div>
        </div>
    </section>

    <!-- Company Overview Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title">Why choose PrimoIT?</h2>
                <p class="section-subtitle">
                    We provide high-quality refurbished IT hardware for businesses around the world
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="card p-8">
                    <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Global Distribution</h3>
                    <p class="text-gray-600">We ship our products worldwide to businesses of all sizes.</p>
                </div>

                <div class="card p-8">
                    <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Competitive Pricing</h3>
                    <p class="text-gray-600">Get enterprise-grade hardware at a fraction of the cost of new equipment.</p>
                </div>

                <div class="card p-8">
                    <div class="w-12 h-12 bg-primary text-white rounded-lg flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Quality Assurance</h3>
                    <p class="text-gray-600">All our products undergo rigorous testing and quality control procedures.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Featured Batches Section -->
    <section class="py-16 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center mb-8">
                <h2 class="section-title mb-0">Available stock</h2>
                <a href="{{ route('batches.index') }}" class="text-primary hover:text-opacity-80 font-medium flex items-center">
                    View all available stock
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                    </svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($featuredBatches as $batch)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $batch->name }}</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">{{ $batch->description ?? 'Batch of premium IT hardware' }}</p>
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Products:</span> {{ $batch->products_count ?? $batch->total_quantity ?? '10+' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Status:</span> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($batch->status === 'active') bg-green-100 text-green-800
                                    @elseif($batch->status === 'reserved') bg-yellow-100 text-yellow-800
                                    @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($batch->status ?? 'Available') }}
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold text-blue-600">
                                @if(isset($batch->total_price))
                                    @formatPrice($batch->total_price)
                                    @else
                                    Contact for pricing
                                    @endif
                                </div>
                            <a href="{{ route('batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-opacity-90 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach

                <!-- Placeholder batches if none are available -->
                @if(count($featuredBatches ?? []) < 3)
                @for($i = count($featuredBatches ?? []); $i < 3; $i++)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">Premium Laptops Batch</h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">A collection of high-quality refurbished business laptops from top brands.</p>
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Products:</span> 15+
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Status:</span> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    Available
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold text-blue-600">
                                Contact for pricing
                            </div>
                            <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-primary hover:bg-opacity-90 transition">
                                Inquire
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
                @endif
            </div>
        </div>
    </section>

    <!-- Product Categories Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="section-title">Our categories</h2>
                <p class="section-subtitle">Find the perfect IT hardware for your business needs</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <a href="#" class="group card overflow-hidden">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-primary transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary transition">Laptops</h3>
                        <p class="text-gray-600 mt-2">Business and premium laptops from top brands</p>
                    </div>
                </a>

                <a href="#" class="group card overflow-hidden">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-primary transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary transition">Desktops</h3>
                        <p class="text-gray-600 mt-2">Powerful desktop computers for office use</p>
                    </div>
                </a>

                <a href="#" class="group card overflow-hidden">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-primary transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M5 12a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v4a2 2 0 01-2 2M5 12a2 2 0 00-2 2v4a2 2 0 002 2h14a2 2 0 002-2v-4a2 2 0 00-2-2m-2-4h.01M17 16h.01" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary transition">Servers</h3>
                        <p class="text-gray-600 mt-2">Enterprise-grade servers for business infrastructure</p>
                    </div>
                </a>

                <a href="#" class="group card overflow-hidden">
                    <div class="h-48 bg-gray-100 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-20 w-20 text-gray-400 group-hover:text-primary transition" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z" />
                        </svg>
                    </div>
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 group-hover:text-primary transition">Components</h3>
                        <p class="text-gray-600 mt-2">Quality components and accessories for IT systems</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-16 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">What Our Clients Say</h2>
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">We take pride in providing exceptional service and products</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            @for($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"We've been working with PrimoIT for the past year, and they've consistently delivered quality hardware for our growing team. Their customer service is exceptional."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 font-semibold">JD</span>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">John Doe</h4>
                            <p class="text-sm text-gray-500">IT Director, Tech Solutions Inc.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            @for($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"The refurbished laptops we purchased from PrimoIT were in excellent condition and performed just like new. We saved significantly compared to buying new equipment."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 font-semibold">JS</span>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">Jane Smith</h4>
                            <p class="text-sm text-gray-500">CFO, Digital Marketing Agency</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-8 rounded-lg shadow-md">
                    <div class="flex items-center mb-4">
                        <div class="text-yellow-400 flex">
                            @for($i = 0; $i < 5; $i++)
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            @endfor
                        </div>
                    </div>
                    <p class="text-gray-600 mb-4">"PrimoIT made the procurement process easy and hassle-free. Their team was knowledgeable and helped us select the right equipment for our specific needs."</p>
                    <div class="flex items-center">
                        <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                            <span class="text-gray-600 font-semibold">RB</span>
                        </div>
                        <div class="ml-3">
                            <h4 class="text-sm font-semibold text-gray-900">Robert Brown</h4>
                            <p class="text-sm text-gray-500">Owner, Small Business Solutions</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Call to Action Section -->
    <section class="py-20 bg-primary text-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl font-bold mb-6">Ready to order from our stock?</h2>
            <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
                Contact us today to discuss your IT hardware needs and find the right equipment for your business.
            </p>
            <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
                <a href="{{ route('batches.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary bg-white hover:bg-gray-100 transition">
                    Available stock
                </a>
                <a href="{{ route('contact') }}" class="inline-flex justify-center items-center px-6 py-3 border border-white text-base font-medium rounded-md text-white bg-transparent hover:bg-white hover:text-primary transition">
                    Contact us
                </a>
            </div>
        </div>
    </section>
</x-public-layout> 