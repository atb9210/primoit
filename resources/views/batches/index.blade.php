<x-public-layout>
    <x-slot name="title">Batches - Available IT Hardware</x-slot>
    <x-slot name="description">Browse our available batches of refurbished IT hardware including laptops, desktops, and servers at competitive prices.</x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Page Header -->
            <div class="max-w-7xl mx-auto text-center mb-12">
                <h1 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">
                    Available Stock
                </h1>
                <p class="mt-3 max-w-2xl mx-auto text-xl text-gray-500 sm:mt-4">
                    Browse our selection of quality IT hardware available for purchase
                </p>
            </div>

            <!-- Filters Section -->
            <div class="bg-white shadow rounded-lg mb-8 p-6">
                <form action="{{ route('batches.index') }}" method="GET" class="flex flex-wrap items-end space-x-4">
                    <div class="flex-grow-0">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="status" name="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md">
                            <option value="">All Statuses</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="reserved" {{ request('status') == 'reserved' ? 'selected' : '' }}>Reserved</option>
                            <option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                    </div>
                    <div class="flex-grow-0">
                        <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                        <input type="number" id="min_price" name="min_price" value="{{ request('min_price') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="flex-grow-0">
                        <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                        <input type="number" id="max_price" name="max_price" value="{{ request('max_price') }}" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                    </div>
                    <div class="flex-grow-0">
                        <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary hover:bg-opacity-90 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Apply Filters
                        </button>
                    </div>
                </form>
            </div>

            <!-- Batches Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($batches as $batch)
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
                            <a href="{{ route('batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @empty
                <div class="col-span-full bg-white rounded-lg shadow-md p-8 text-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No batches available</h3>
                    <p class="text-gray-500 mb-6">We don't have any batches matching your criteria at the moment.</p>
                    <a href="{{ route('contact') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                        Contact Us for Special Requests
                    </a>
                </div>

                <!-- Placeholder batches for demo purposes -->
                @for($i = 0; $i < 6; $i++)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-gray-900 mb-2">
                            @if($i % 3 == 0)
                                Premium Laptops Batch
                            @elseif($i % 3 == 1)
                                Office Desktops Collection
                            @else
                                Enterprise Servers Package
                            @endif
                        </h3>
                        <p class="text-gray-600 mb-4 line-clamp-2">
                            @if($i % 3 == 0)
                                A collection of high-quality refurbished business laptops from top brands including Dell, HP, and Lenovo.
                            @elseif($i % 3 == 1)
                                Complete desktop systems perfect for office environments, including monitors and peripherals.
                            @else
                                Enterprise-grade servers with comprehensive specifications suitable for data centers and business operations.
                            @endif
                        </p>
                        <div class="flex justify-between items-center mb-4">
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Products:</span> {{ 5 + ($i * 3) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                <span class="font-medium">Status:</span> 
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($i % 3 == 0) bg-green-100 text-green-800">Active
                                    @elseif($i % 3 == 1) bg-yellow-100 text-yellow-800">Reserved
                                    @else bg-blue-100 text-blue-800">Sold
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            <div class="text-lg font-bold text-blue-600">
                                @if($i % 3 == 0)
                                    €{{ number_format(1500 + ($i * 500), 2) }}
                                @elseif($i % 3 == 1)
                                    €{{ number_format(3000 + ($i * 500), 2) }}
                                @else
                                    €{{ number_format(5000 + ($i * 1000), 2) }}
                                @endif
                            </div>
                            <a href="#" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
                @endfor
                @endforelse
            </div>

            <!-- Pagination -->
            @if(isset($batches) && $batches->hasPages())
            <div class="mt-8">
                {{ $batches->links() }}
            </div>
            @endif
        </div>
    </div>
</x-public-layout> 