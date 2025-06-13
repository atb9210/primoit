<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Batch Details') }}: {{ $batch->name }}
            </h2>
            <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center px-3 py-2 bg-gray-100 border border-gray-300 rounded-md font-medium text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                {{ __('Back to Batches') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            @if (session('success'))
                <div class="mb-4 bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Batch Overview -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <!-- Action Buttons -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <a href="{{ route('admin.batches.edit', $batch) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            {{ __('Edit Batch') }}
                        </a>
                        <a href="{{ route('admin.batches.manage-products', $batch) }}" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            {{ __('Manage Products') }}
                        </a>
                        <a href="{{ route('admin.batches.print-label', $batch) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            {{ __('Print Label') }}
                        </a>
                        <a href="{{ route('admin.batches.print-product-labels', $batch) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                            </svg>
                            {{ __('Print Product Labels') }}
                        </a>
                        <a href="{{ route('admin.batches.generate-pdf', $batch) }}" target="_blank" class="inline-flex items-center px-3 py-2 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            {{ __('Generate PDF') }}
                        </a>
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                Batch Information
                            </span>
                        </h3>
                        <div class="mt-2 md:mt-0">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-md text-sm font-medium 
                                @if($batch->status === 'active') bg-green-100 text-green-800
                                @elseif($batch->status === 'reserved') bg-amber-100 text-amber-800
                                @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                @else bg-gray-100 text-gray-800 @endif">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    @if($batch->status === 'active')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @elseif($batch->status === 'reserved')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    @elseif($batch->status === 'sold')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    @endif
                                </svg>
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-50 p-4 rounded-md border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-gray-600">Reference Code</p>
                            <p class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                                {{ $batch->reference_code ?? 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-gray-600">Quantity</p>
                            <p class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M3 14h18m-9-4v8m-7 0h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                {{ $batch->unit_quantity }} units
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-gray-600">Unit Price</p>
                            <p class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @formatPrice($batch->unit_price)
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md border-l-4 border-blue-500">
                            <p class="text-sm font-medium text-gray-600">Total Price</p>
                            <p class="text-lg font-semibold text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                @formatPrice($batch->total_price)
                            </p>
                        </div>
                    </div>

                    @if($batch->description)
                        <div class="mt-4 bg-gray-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-gray-600 mb-1">Description</p>
                            <p class="text-gray-900 flex items-start">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>{{ $batch->description }}</span>
                            </p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-gray-600 mb-1">Available From</p>
                            <p class="text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $batch->available_from ? $batch->available_from->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-md">
                            <p class="text-sm font-medium text-gray-600 mb-1">Available Until</p>
                            <p class="text-gray-900 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ $batch->available_until ? $batch->available_until->format('d/m/Y') : 'N/A' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                Products
                            </span>
                        </h3>
                        <div class="flex items-center space-x-2">
                            <span class="inline-flex items-center px-3 py-1 rounded-md text-sm font-medium bg-blue-50 text-blue-800">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                                </svg>
                                {{ is_array($batch->products) ? count($batch->products) : 0 }} Products
                            </span>
                            <button type="button" onclick="openAddProductModal()" class="inline-flex items-center px-3 py-1 bg-blue-600 border border-transparent rounded-md font-medium text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                                Add Product
                            </button>
                        </div>
                    </div>
                    
                    @if(is_array($batch->products) && count($batch->products) > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white border border-gray-200 text-sm">
                            <thead>
                                <tr>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">ID</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Manufacturer</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Model</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Grade</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tech Grade</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Price</th>
                                    <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Qty</th>
                                    
                                    @if(is_array($batch->specifications))
                                        @foreach($batch->specifications as $key => $value)
                                            @if(!in_array($key, ['grade', 'visual_grade', 'tech_grade', 'original_specs', 'id']))
                                                <th class="px-3 py-2 bg-gray-50 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($batch->products as $product)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $product['id'] ?? '-' }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $product['manufacturer'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $product['model'] }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $product['grade'] ?? '-' }}</td>
                                    <td class="px-3 py-2 whitespace-nowrap 
                                        @if(isset($product['tech_grade']))
                                            @if($product['tech_grade'] === 'Working')
                                                text-green-600 font-semibold
                                            @elseif($product['tech_grade'] === 'Working*')
                                                text-amber-600 font-semibold
                                            @elseif($product['tech_grade'] === 'Not working')
                                                text-red-600 font-semibold
                                            @else
                                                text-gray-900
                                            @endif
                                        @else
                                            text-gray-500
                                        @endif">
                                        {{ $product['tech_grade'] ?? '-' }}
                                        @if(isset($product['problems']) && !empty($product['problems']))
                                            <span class="block text-gray-500 text-xs italic truncate max-w-xs">{{ $product['problems'] }}</span>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900">@formatPrice($product['price'])</td>
                                    <td class="px-3 py-2 whitespace-nowrap text-gray-900">{{ $product['quantity'] }}</td>
                                    
                                    @if(is_array($batch->specifications))
                                        @foreach($batch->specifications as $key => $value)
                                            @if(!in_array($key, ['grade', 'visual_grade', 'tech_grade', 'original_specs', 'id']))
                                            <td class="px-3 py-2 whitespace-nowrap text-gray-900">
                                                @if(isset($product[$key]))
                                                    @if(is_array($product[$key]))
                                                        {{ json_encode($product[$key]) }}
                                                    @else
                                                        {{ $product[$key] }}
                                                    @endif
                                                @else
                                                    <span class="text-gray-400">-</span>
                                                @endif
                                            </td>
                                            @endif
                                        @endforeach
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                        <div class="bg-gray-50 p-4 rounded-md text-center">
                            <p class="text-gray-500">No products in this batch.</p>
                        </div>
                    @endif
                    
                    @if($batch->notes)
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-2">Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-md">
                                <p class="text-gray-900 flex items-start">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span>{{ $batch->notes }}</span>
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Images -->
            @if(is_array($batch->images) && count($batch->images) > 0)
                <div class="bg-white overflow-hidden shadow-sm rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">
                            <span class="flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                Images
                            </span>
                        </h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($batch->images as $image)
                                <div class="bg-gray-100 rounded-md overflow-hidden shadow-sm border border-gray-200">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Product Image" class="w-full h-48 object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto">
            <div class="p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Add New Product</h3>
                    <button type="button" onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <form id="add-product-form" action="{{ route('admin.batches.add-product', $batch) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Product Details -->
                        <div>
                            <div class="grid grid-cols-1 gap-4 mb-4">
                                <div>
                                    <label for="manufacturer" class="block text-sm font-medium text-gray-700 mb-1">Manufacturer *</label>
                                    <input type="text" name="manufacturer" id="manufacturer" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $batch->product_manufacturer }}">
                                </div>
                                
                                <div>
                                    <label for="model" class="block text-sm font-medium text-gray-700 mb-1">Model *</label>
                                    <input type="text" name="model" id="model" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $batch->product_model }}">
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="grade" class="block text-sm font-medium text-gray-700 mb-1">Condition Grade</label>
                                        <select name="grade" id="grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                            <option value="">Select a grade</option>
                                            <option value="A">A (Excellent)</option>
                                            <option value="B">B (Good)</option>
                                            <option value="C">C (Fair)</option>
                                            <option value="D">D (Poor)</option>
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label for="tech_grade" class="block text-sm font-medium text-gray-700 mb-1">Tech Grade</label>
                                        <select name="tech_grade" id="tech_grade" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" onchange="toggleProblemsField()">
                                            <option value="Working">Working</option>
                                            <option value="Working*">Working*</option>
                                            <option value="Not Working">Not Working</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <!-- Problems field (conditionally shown) -->
                                <div id="problems_container" class="mt-3 hidden">
                                    <label for="problems" class="block text-sm font-medium text-gray-700 mb-1">Problems</label>
                                    <textarea name="problems" id="problems" rows="2" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Describe the issues with this product..."></textarea>
                                    <p class="mt-1 text-xs text-gray-500">Please describe what problems or issues the product has.</p>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Price (€) *</label>
                                        <input type="number" name="price" id="price" min="0" step="0.01" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="{{ $batch->unit_price }}">
                                    </div>
                                    
                                    <div>
                                        <label for="quantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity *</label>
                                        <input type="number" name="quantity" id="quantity" min="1" required class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" value="1">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Product Images and Parameters -->
                        <div>
                            <!-- Product Images Section -->
                            <div class="mb-4">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Product Images (Max 4)</h4>
                                
                                <div class="mt-1 flex justify-center px-4 py-3 border-2 border-gray-300 border-dashed rounded-md">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-8 w-8 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-gray-600 justify-center">
                                            <label for="product_images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none">
                                                <span>Upload</span>
                                                <input id="product_images" name="product_images[]" type="file" class="sr-only" multiple accept="image/*">
                                            </label>
                                            <p class="pl-1">or drag images</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Image Size Check and Compression -->
                                <div id="image-size-warning" class="mt-2 hidden">
                                    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-3 flex items-start">
                                        <div class="flex-shrink-0">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-700" id="large-image-message">
                                                Some images exceed 2MB. This may cause upload issues.
                                            </p>
                                            <div class="mt-2">
                                                <button type="button" id="compress-images-btn" class="inline-flex items-center px-3 py-1 border border-transparent text-xs leading-4 font-medium rounded-md text-yellow-700 bg-yellow-100 hover:bg-yellow-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500">
                                                    Compress Images
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Compression Progress -->
                                <div id="compression-progress-container" class="mt-2 hidden">
                                    <div class="bg-blue-50 border-l-4 border-blue-400 p-3">
                                        <div class="flex items-center justify-between mb-1">
                                            <p class="text-sm text-blue-700">Compressing images...</p>
                                            <p class="text-xs text-blue-700" id="compression-percentage">0%</p>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div id="compression-progress-bar" class="bg-blue-600 h-2 rounded-full" style="width: 0%"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Compression Results -->
                                <div id="compression-results" class="mt-2 hidden">
                                    <div class="bg-green-50 border-l-4 border-green-400 p-3">
                                        <div class="flex">
                                            <div class="flex-shrink-0">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                            <div class="ml-3">
                                                <p class="text-sm text-green-700" id="compression-results-text">
                                                    Images compressed successfully.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div id="product-image-preview-container" class="mt-2 hidden">
                                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-2" id="product-image-preview">
                                        <!-- Image previews will be inserted here -->
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Click on an image to set it as default</p>
                                    <input type="hidden" name="product_default_image" id="product_default_image" value="0">
                                </div>
                            </div>
                            
                            <!-- Parameters Section (based on batch specifications) -->
                            @if(is_array($batch->specifications) && count($batch->specifications) > 0)
                                <div class="mb-4">
                                    <h4 class="text-sm font-medium text-gray-700 mb-3">Additional Parameters</h4>
                                    <div class="grid grid-cols-2 gap-3">
                                        @foreach($batch->specifications as $key => $value)
                                            <div>
                                                <label for="param_{{ $key }}" class="block text-sm font-medium text-gray-700 mb-1">{{ ucfirst(str_replace('_', ' ', $key)) }}</label>
                                                <input type="text" id="param_{{ $key }}" name="param_keys[]" value="{{ $key }}" hidden>
                                                <input type="text" name="param_values[]" class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Enter value">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-4">
                        <button type="button" onclick="closeAddProductModal()" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150 mr-2">
                            Cancel
                        </button>
                        <button type="button" onclick="submitAddProductForm()" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                            Add Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openAddProductModal() {
            document.getElementById('addProductModal').classList.remove('hidden');
            document.getElementById('manufacturer').focus();
        }
        
        function closeAddProductModal() {
            document.getElementById('addProductModal').classList.add('hidden');
        }
        
        function toggleProblemsField() {
            const problemsContainer = document.getElementById('problems_container');
            const techGrade = document.getElementById('tech_grade').value;
            
            if (techGrade === 'Working*' || techGrade === 'Not Working') {
                problemsContainer.classList.remove('hidden');
            } else {
                problemsContainer.classList.add('hidden');
            }
        }
        
        function submitAddProductForm() {
            // Mostra un indicatore di caricamento o disabilita il pulsante per evitare doppi clic
            const submitButton = document.querySelector('button[onclick="submitAddProductForm()"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<svg class="animate-spin h-4 w-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Processing...';
            
            // Invia il form
            const form = document.getElementById('add-product-form');
            
            // Usa fetch per inviare il form in modo asincrono
            fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    // Ricarica la pagina per mostrare il prodotto aggiunto
                    window.location.reload();
                } else {
                    // Gestisci l'errore
                    response.json().then(data => {
                        console.error('Error:', data);
                        alert('Si è verificato un errore durante l\'aggiunta del prodotto. Controlla i dati inseriti.');
                        submitButton.disabled = false;
                        submitButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg> Add Product';
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Si è verificato un errore durante l\'aggiunta del prodotto.');
                submitButton.disabled = false;
                submitButton.innerHTML = '<svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" /></svg> Add Product';
            });
        }

        // Image preview functionality
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('product_images');
            const imagePreviewContainer = document.getElementById('product-image-preview-container');
            const imagePreview = document.getElementById('product-image-preview');
            const defaultImageIndex = document.getElementById('product_default_image');
            
            // Inizializza il campo Problems in base al valore attuale di Tech Grade
            toggleProblemsField();
            
            // Drag and drop functionality
            const dropZone = imageInput.closest('.border-dashed');
            
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
            });
            
            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });
            
            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });
            
            function highlight() {
                dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
            }
            
            function unhighlight() {
                dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            }
            
            dropZone.addEventListener('drop', handleDrop, false);
            
            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;
                imageInput.files = files;
                handleFiles(files);
            }
            
            // Image preview on file input change
            imageInput.addEventListener('change', function() {
                handleFiles(this.files);
            });
            
            // Verifica dimensione immagini
            async function checkImageSizes(files) {
                let hasLargeImages = false;
                let totalSize = 0;
                
                for (const file of files) {
                    if (file.size > 2 * 1024 * 1024) { // 2MB
                        hasLargeImages = true;
                    }
                    totalSize += file.size;
                }
                
                const imageSizeWarning = document.getElementById('image-size-warning');
                const largeImageMessage = document.getElementById('large-image-message');
                
                if (hasLargeImages) {
                    imageSizeWarning.classList.remove('hidden');
                    const sizeMB = (totalSize / (1024 * 1024)).toFixed(2);
                    largeImageMessage.textContent = `Some images exceed 2MB (total: ${sizeMB}MB). This may cause upload issues.`;
                } else {
                    imageSizeWarning.classList.add('hidden');
                }
                
                return hasLargeImages;
            }
            
            // Gestione compressione immagini
            document.getElementById('compress-images-btn').addEventListener('click', async function() {
                const files = imageInput.files;
                if (!files || files.length === 0) return;
                
                // Mostra il contenitore di progresso
                const progressContainer = document.getElementById('compression-progress-container');
                progressContainer.classList.remove('hidden');
                
                // Nascondi il warning
                document.getElementById('image-size-warning').classList.add('hidden');
                
                // Importa la libreria di compressione
                const script = document.createElement('script');
                script.src = 'https://cdn.jsdelivr.net/npm/browser-image-compression@2.0.0/dist/browser-image-compression.js';
                document.head.appendChild(script);
                
                script.onload = async function() {
                    const imageCompression = window.imageCompression;
                    const compressedFiles = [];
                    let totalProgress = 0;
                    const progressBar = document.getElementById('compression-progress-bar');
                    const progressPercentage = document.getElementById('compression-percentage');
                    
                    const options = {
                        maxSizeMB: 1.5,
                        maxWidthOrHeight: 1920,
                        useWebWorker: true,
                        onProgress: function(progress) {
                            const fileProgress = progress / files.length + (totalProgress / files.length);
                            const percentage = Math.round(fileProgress * 100);
                            progressBar.style.width = `${percentage}%`;
                            progressPercentage.textContent = `${percentage}%`;
                        }
                    };
                    
                    let totalOriginalSize = 0;
                    let totalCompressedSize = 0;
                    
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        totalOriginalSize += file.size;
                        
                        try {
                            const compressedFile = await imageCompression(file, options);
                            compressedFiles.push(compressedFile);
                            totalCompressedSize += compressedFile.size;
                        } catch (error) {
                            console.error('Error compressing image:', error);
                            compressedFiles.push(file); // Use original if compression fails
                            totalCompressedSize += file.size;
                        }
                        
                        totalProgress += 1;
                    }
                    
                    // Nascondi il contenitore di progresso
                    progressContainer.classList.add('hidden');
                    
                    // Mostra i risultati
                    const resultsContainer = document.getElementById('compression-results');
                    const resultsText = document.getElementById('compression-results-text');
                    
                    const originalSizeMB = (totalOriginalSize / (1024 * 1024)).toFixed(2);
                    const compressedSizeMB = (totalCompressedSize / (1024 * 1024)).toFixed(2);
                    const savingPercentage = Math.round((1 - (totalCompressedSize / totalOriginalSize)) * 100);
                    
                    resultsText.textContent = `Images compressed: ${originalSizeMB}MB → ${compressedSizeMB}MB (${savingPercentage}% saved)`;
                    resultsContainer.classList.remove('hidden');
                    
                    // Crea un nuovo oggetto FileList con i file compressi
                    const dataTransfer = new DataTransfer();
                    compressedFiles.forEach(file => {
                        dataTransfer.items.add(file);
                    });
                    
                    // Aggiorna il campo di input con i file compressi
                    imageInput.files = dataTransfer.files;
                    
                    // Aggiorna le anteprime
                    handleFiles(imageInput.files);
                    
                    // Nascondi i risultati dopo 5 secondi
                    setTimeout(() => {
                        resultsContainer.classList.add('hidden');
                    }, 5000);
                };
            });
            
            // Controlla la dimensione delle immagini quando vengono caricate
            function handleFiles(files) {
                // Clear the preview
                imagePreview.innerHTML = '';
                
                if (files && files.length > 0) {
                    imagePreviewContainer.classList.remove('hidden');
                    
                    // Check image sizes
                    checkImageSizes(files);
                    
                    // Limit to 4 images
                    const filesToProcess = Array.from(files).slice(0, 4);
                    
                    // Create previews for each image
                    filesToProcess.forEach((file, index) => {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            const div = document.createElement('div');
                            div.className = 'relative group cursor-pointer border rounded-md overflow-hidden';
                            div.dataset.index = index;
                            
                            // Check if this is the default image
                            const isDefault = parseInt(defaultImageIndex.value) === index;
                            
                            // Add a border if it's the default image
                            if (isDefault) {
                                div.classList.add('ring-2', 'ring-indigo-500');
                            }
                            
                            div.innerHTML = `
                                <img src="${e.target.result}" alt="Preview" class="h-24 w-full object-cover">
                                <div class="absolute inset-0 bg-black bg-opacity-40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <p class="text-white text-xs font-medium">Set as default</p>
                                </div>
                                ${isDefault ? '<div class="absolute top-0 right-0 bg-indigo-500 text-white text-xs px-2 py-1">Default</div>' : ''}
                            `;
                            
                            div.addEventListener('click', function() {
                                // Remove highlight from all images
                                document.querySelectorAll('#product-image-preview > div').forEach(el => {
                                    el.classList.remove('ring-2', 'ring-indigo-500');
                                    el.querySelector('.absolute.top-0.right-0')?.remove();
                                });
                                
                                // Highlight this one
                                this.classList.add('ring-2', 'ring-indigo-500');
                                
                                // Add the "Default" badge
                                if (!this.querySelector('.absolute.top-0.right-0')) {
                                    const badge = document.createElement('div');
                                    badge.className = 'absolute top-0 right-0 bg-indigo-500 text-white text-xs px-2 py-1';
                                    badge.textContent = 'Default';
                                    this.appendChild(badge);
                                }
                                
                                // Update the hidden input
                                defaultImageIndex.value = this.dataset.index;
                            });
                            
                            imagePreview.appendChild(div);
                        };
                        
                        reader.readAsDataURL(file);
                    });
                } else {
                    imagePreviewContainer.classList.add('hidden');
                }
            }
        });
    </script>
</x-admin-layout> 