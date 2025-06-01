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
                        <a href="{{ route('batches.index') }}" class="ml-2 hover:text-gray-700">Batches</a>
                    </li>
                    <li class="flex items-center">
                        <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                        </svg>
                        <span class="ml-2 font-medium text-gray-900">{{ $batch->name }}</span>
                    </li>
                </ol>
            </nav>

            <!-- Batch Header -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden mb-8">
                <div class="p-6 sm:p-8">
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
                                    @if(isset($batch->total_price))
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
            </div>

            <!-- Batch Description and Details -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <!-- Description Column -->
                <div class="lg:col-span-2">
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Description</h2>
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

                <!-- Summary Column -->
                <div>
                    <div class="bg-white shadow-md rounded-lg overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-gray-900 mb-4">Batch Summary</h2>
                            <dl class="space-y-3">
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Status</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ ucfirst($batch->status ?? 'Available') }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Total Products</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $batch->products->count() ?? $batch->total_quantity ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Total Quantity</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $batch->total_quantity ?? 'N/A' }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Available From</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $batch->available_from ? $batch->available_from->format('d/m/Y') : 'Immediately' }}</dd>
                                </div>
                                @if($batch->available_until)
                                <div class="flex justify-between">
                                    <dt class="text-sm text-gray-500">Available Until</dt>
                                    <dd class="text-sm font-medium text-gray-900">{{ $batch->available_until->format('d/m/Y') }}</dd>
                                </div>
                                @endif
                            </dl>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products in this batch -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Products in this Batch</h2>

                    @if($batch->products && $batch->products->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specifications</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($batch->products as $product)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">{{ $product->producer }} {{ $product->model }}</div>
                                                <div class="text-sm text-gray-500">{{ $product->type }}</div>
                                                @if(isset($product->name))
                                                    <div class="text-xs text-gray-500 mt-1">{{ $product->name }}</div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-900">
                                                    <ul class="list-disc list-inside text-xs">
                                                        @if($product->cpu)
                                                            <li>CPU: {{ $product->cpu }}</li>
                                                        @endif
                                                        @if($product->ram)
                                                            <li>RAM: {{ $product->ram }}</li>
                                                        @endif
                                                        @if($product->drive)
                                                            <li>Storage: {{ $product->drive }}</li>
                                                        @endif
                                                        @if($product->screen_size)
                                                            <li>Screen: {{ $product->screen_size }}</li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $product->pivot->quantity }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @formatPrice($product->pivot->unit_price)
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @php
                                                    $total = (float)$product->pivot->unit_price * (int)$product->pivot->quantity;
                                                @endphp
                                                @formatPrice($total)
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <!-- Example Products (for demo) -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Specifications</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Dell Latitude 5420</div>
                                            <div class="text-sm text-gray-500">Laptop</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                <ul class="list-disc list-inside text-xs">
                                                    <li>CPU: Intel Core i5-1135G7</li>
                                                    <li>RAM: 16GB DDR4</li>
                                                    <li>Storage: 512GB SSD</li>
                                                    <li>Screen: 14" FHD</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            5
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €650.00
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €3,250.00
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">HP EliteBook 840</div>
                                            <div class="text-sm text-gray-500">Laptop</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                <ul class="list-disc list-inside text-xs">
                                                    <li>CPU: Intel Core i7-10510U</li>
                                                    <li>RAM: 16GB DDR4</li>
                                                    <li>Storage: 1TB SSD</li>
                                                    <li>Screen: 14" FHD</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            3
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €750.00
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €2,250.00
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">Lenovo ThinkPad X1 Carbon</div>
                                            <div class="text-sm text-gray-500">Laptop</div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900">
                                                <ul class="list-disc list-inside text-xs">
                                                    <li>CPU: Intel Core i7-1165G7</li>
                                                    <li>RAM: 32GB DDR4</li>
                                                    <li>Storage: 1TB SSD</li>
                                                    <li>Screen: 14" 4K</li>
                                                </ul>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            2
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €950.00
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            €1,900.00
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Call to Action -->
            <div class="bg-blue-50 rounded-lg shadow-md p-8 mt-8 text-center">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Interested in this batch?</h2>
                <p class="text-lg text-gray-600 mb-6 max-w-3xl mx-auto">Contact our team for more information, availability, and pricing options.</p>
                <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-4">
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
</x-public-layout> 