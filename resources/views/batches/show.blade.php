<x-public-layout>
    <x-slot name="title">{{ $batch->name }} - Batch Details</x-slot>
    <x-slot name="description">View detailed information about {{ $batch->name }} batch including specifications, pricing, and products included.</x-slot>

    <div class="bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Breadcrumbs -->
            <nav class="flex mb-8" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-2 text-sm text-gray-500">
                    <li>
                        <a href="{{ route('home') }}" class="hover:text-gray-700">Home</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <a href="{{ route('batches.index') }}" class="ml-2 hover:text-gray-700">Available Stock</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 font-medium text-gray-900">{{ $batch->name }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Main Content Container -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
                <!-- Batch Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div class="mb-4 lg:mb-0">
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">{{ $batch->name }}</h1>
                            <p class="text-sm text-gray-500 mb-2">Reference: <span class="font-medium">{{ $batch->reference_code ?? 'N/A' }}</span></p>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($batch->status === 'active') bg-green-100 text-green-800
                                    @elseif($batch->status === 'reserved') bg-yellow-100 text-yellow-800
                                    @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif mr-2">
                                    {{ ucfirst($batch->status ?? 'Available') }}
                                </span>
                                
                                @if($batch->available_from || $batch->available_until)
                                <span class="text-sm text-gray-500">
                                    @if($batch->available_from)
                                    Available from {{ $batch->available_from->format('d/m/Y') }}
                                    @endif
                                    @if($batch->available_until)
                                    until {{ $batch->available_until->format('d/m/Y') }}
                                    @endif
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <div class="mb-4 sm:mb-0 sm:mr-6">
                                <p class="text-sm text-gray-500">Total Price</p>
                                <p class="text-3xl font-bold text-blue-600">
                                    @if($batch->total_price !== null)
                                        @formatPrice($batch->total_price)
                                    @else
                                        Contact for pricing
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('contact') }}?subject=Inquiry about {{ urlencode($batch->name) }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                                Contact About This Batch
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Batch Summary Cards -->
                <div class="p-6 border-b border-gray-200">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                        <!-- Status -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Status</h4>
                            <div class="flex items-center">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($batch->status === 'active') bg-green-100 text-green-800
                                    @elseif($batch->status === 'reserved') bg-yellow-100 text-yellow-800
                                    @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif mr-2">
                                    {{ ucfirst($batch->status ?? 'Available') }}
                                </span>
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Cost</h4>
                            <div class="flex items-center">
                                <div class="text-xl font-bold text-gray-900">
                                    @if($batch->total_price !== null)
                                        @formatPrice($batch->total_price)
                                    @else
                                        Contact for pricing
                                    @endif
                                </div>
                                <div class="text-sm text-gray-500 ml-2">Total</div>
                            </div>
                            @if($batch->products->count() > 0 && $batch->total_price !== null)
                                <div class="text-md font-medium text-gray-700 mt-1">
                                    ~@formatPrice($batch->total_price / $batch->products->count()) Avg/unit
                                </div>
                            @endif
                        </div>

                        <!-- Quantity -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Quantity</h4>
                            <div class="text-xl font-bold text-gray-900">
                                {{ $batch->products->count() ?? $batch->total_quantity ?? 'N/A' }}
                                <span class="text-sm text-gray-500 ml-1">units</span>
                            </div>
                        </div>

                        <!-- Availability -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <h4 class="text-lg font-semibold text-gray-900 mb-2">Availability</h4>
                            <div class="text-md font-medium text-gray-700">
                                @if($batch->available_from)
                                    From: {{ $batch->available_from->format('d/m/Y') }}
                                @else
                                    Available immediately
                                @endif
                            </div>
                            @if($batch->available_until)
                                <div class="text-md font-medium text-gray-700 mt-1">
                                    Until: {{ $batch->available_until->format('d/m/Y') }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-wrap gap-4">
                        <a href="{{ route('contact') }}?subject=Inquiry about {{ urlencode($batch->name) }}" class="inline-flex justify-center items-center px-6 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-sm text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            Contact About This Batch
                        </a>
                        <a href="{{ route('batches.index') }}" class="inline-flex justify-center items-center px-6 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-sm text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            Browse Other Batches
                        </a>
                    </div>
                </div>

                <!-- Tabs Navigation -->
                <div class="px-6 pt-6">
                    <div class="border-b border-gray-200 mb-6">
                        <ul class="flex -mb-px" id="tabs" role="tablist">
                            <li class="mr-1" role="presentation">
                                <button class="py-2 px-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600 active" id="products-tab" data-tab="products" type="button" role="tab" aria-controls="products" aria-selected="true">
                                    Products ({{ $batch->products->count() }})
                                </button>
                            </li>
                            <li class="mr-1" role="presentation">
                                <button class="py-2 px-4 text-sm font-medium text-gray-500 border-b-2 border-transparent" id="description-tab" data-tab="description" type="button" role="tab" aria-controls="description" aria-selected="false">
                                    Description
                                </button>
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Tab Content -->
                <div class="px-6 pb-6" id="tabContent">
                    <!-- Products Tab -->
                    <div class="block" id="products" role="tabpanel" aria-labelledby="products-tab">
                        <div class="overflow-x-auto">
                            @if($batch->products && $batch->products->count() > 0)
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specifications</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($batch->products as $index => $product)
                                            <tr class="{{ $index % 2 == 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50">
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                                        @if($product->images && $product->images->count() > 0)
                                                            <img src="{{ asset('storage/' . $product->primaryImage?->path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
                                                        @else
                                                            <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500">No Image</div>
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4">
                                                    <div class="text-sm font-medium text-gray-900">{{ $product->producer }} {{ $product->model }}</div>
                                                    <div class="text-sm text-gray-500">{{ $product->type }}</div>
                                                    @if(isset($product->name))
                                                        <div class="text-xs text-gray-500 mt-1">{{ $product->name }}</div>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4">
                                                    <div class="text-sm text-gray-900">
                                                        <ul class="list-none text-xs space-y-1">
                                                            @if($product->cpu)
                                                                <li><span class="font-medium">CPU:</span> {{ $product->cpu }}</li>
                                                            @endif
                                                            @if($product->ram)
                                                                <li><span class="font-medium">RAM:</span> {{ $product->ram }}</li>
                                                            @endif
                                                            @if($product->drive)
                                                                <li><span class="font-medium">Storage:</span> {{ $product->drive }}</li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td class="px-3 py-4 whitespace-nowrap">
                                                    @if($product->screen_size)
                                                        <div class="text-sm text-gray-900">{{ $product->screen_size }}</div>
                                                    @else
                                                        <div class="text-sm text-gray-500">-</div>
                                                    @endif
                                                </td>
                                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                    {{ $product->pivot->quantity }}
                                                </td>
                                                <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    @formatPrice($product->pivot->unit_price)
                                                </td>
                                                <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    @php
                                                        $total = (float)$product->pivot->unit_price * (int)$product->pivot->quantity;
                                                    @endphp
                                                    @formatPrice($total)
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <!-- Example Products (for demo) -->
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specifications</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Screen</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-3 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        <tr class="bg-white hover:bg-blue-50">
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                                    <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500">No Image</div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm font-medium text-gray-900">DELL LATITUDE 7390</div>
                                                <div class="text-sm text-gray-500">LAPTOP</div>
                                                <div class="text-xs text-gray-500 mt-1">LATITUDE 7390</div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <ul class="list-none text-xs space-y-1">
                                                        <li><span class="font-medium">CPU:</span> INTEL CORE I5 8350U 1,7 GHz</li>
                                                        <li><span class="font-medium">RAM:</span> 8 GB</li>
                                                        <li><span class="font-medium">Storage:</span> 256 GB NVME</li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">13,3'' (1920x1080)</div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                1
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                                €0.00
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                €0.00
                                            </td>
                                        </tr>
                                        <!-- More example rows for the demo -->
                                        <tr class="bg-gray-50 hover:bg-blue-50">
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="flex-shrink-0 h-20 w-20 rounded-md overflow-hidden">
                                                    <div class="h-full w-full flex items-center justify-center bg-gray-200 text-gray-500">No Image</div>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm font-medium text-gray-900">DELL PRECISION 5530</div>
                                                <div class="text-sm text-gray-500">LAPTOP</div>
                                                <div class="text-xs text-gray-500 mt-1">PRECISION 5530</div>
                                            </td>
                                            <td class="px-3 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <ul class="list-none text-xs space-y-1">
                                                        <li><span class="font-medium">CPU:</span> INTEL CORE I5 8400H 2,5 GHz</li>
                                                        <li><span class="font-medium">RAM:</span> 32 GB</li>
                                                        <li><span class="font-medium">Storage:</span> 512 GB NVME</li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">15,6'' (1920x1080)</div>
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900 font-medium">
                                                1
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm text-gray-900">
                                                €0.00
                                            </td>
                                            <td class="px-3 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                €0.00
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>

                    <!-- Description Tab -->
                    <div class="hidden" id="description" role="tabpanel" aria-labelledby="description-tab">
                        <div class="prose max-w-none text-gray-600">
                            @if($batch->description)
                                <p>{{ $batch->description }}</p>
                            @else
                                <p>This batch contains premium quality IT hardware, carefully refurbished and tested to ensure optimal performance. Perfect for businesses looking to upgrade their IT infrastructure at a competitive price.</p>
                                <p>All items in this batch come with our standard warranty and technical support.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Interested in this batch -->
            <div class="mt-8 text-center">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Interested in this batch?</h3>
                <p class="text-gray-600 mb-6">Contact our team for more information, availability, and pricing options.</p>
                <div class="flex flex-col sm:flex-row justify-center gap-4">
                    <a href="{{ route('contact') }}?subject=Inquiry about {{ urlencode($batch->name) }}" class="inline-flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 transition">
                        Contact Us About This Batch
                    </a>
                    <a href="{{ route('batches.index') }}" class="inline-flex justify-center items-center px-6 py-3 border border-gray-300 text-base font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 transition">
                        Browse Other Batches
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for tab navigation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabs = document.querySelectorAll('[data-tab]');
            
            tabs.forEach(tab => {
                tab.addEventListener('click', () => {
                    // Remove active class from all tabs
                    tabs.forEach(t => {
                        t.classList.remove('text-blue-600', 'border-blue-600');
                        t.classList.add('text-gray-500', 'border-transparent');
                        t.setAttribute('aria-selected', 'false');
                    });
                    
                    // Add active class to clicked tab
                    tab.classList.remove('text-gray-500', 'border-transparent');
                    tab.classList.add('text-blue-600', 'border-blue-600');
                    tab.setAttribute('aria-selected', 'true');
                    
                    // Show corresponding tab content
                    const tabId = tab.getAttribute('data-tab');
                    document.querySelectorAll('[role="tabpanel"]').forEach(panel => {
                        panel.classList.add('hidden');
                    });
                    document.getElementById(tabId).classList.remove('hidden');
                });
            });
        });
    </script>
</x-public-layout> 