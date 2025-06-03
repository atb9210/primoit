<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Batch Details') }}: {{ $batch->name }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.batches.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Batches') }}
                </a>
                <a href="{{ route('admin.batches.edit', $batch) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Batch') }}
                </a>
                <a href="{{ route('admin.batches.manage-products', $batch) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    {{ __('Manage Products') }}
                </a>
                <a href="{{ route('admin.batches.print-label', $batch) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-amber-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    {{ __('Print Label') }}
                </a>

                <a href="{{ route('admin.batches.print-product-labels', $batch) }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-indigo-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    {{ __('Print Product Labels') }}
                </a>

                <!-- Pulsante alternativo in caso si utilizzi un altro stile -->
                <a href="{{ route('admin.batches.print-label', $batch) }}" target="_blank" class="bg-amber-500 text-white px-4 py-2 rounded-md uppercase text-xs font-bold flex items-center ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" />
                    </svg>
                    PRINT LABEL
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded shadow-sm" role="alert">
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
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Batch Information</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Reference Code</p>
                            <p class="text-lg font-medium text-gray-900">{{ $batch->reference_code ?? 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Status</p>
                            <p class="text-lg font-medium">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    @if($batch->status === 'active') bg-green-100 text-green-800
                                    @elseif($batch->status === 'reserved') bg-yellow-100 text-yellow-800
                                    @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                    @else bg-gray-100 text-gray-800 @endif">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Quantity</p>
                            <p class="text-lg font-medium text-gray-900">{{ $batch->unit_quantity }} units</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Price</p>
                            <p class="text-lg font-medium text-gray-900">
                                @formatPrice($batch->total_price) (Total)<br>
                                <span class="text-sm">@formatPrice($batch->unit_price) / unit</span>
                            </p>
                        </div>
                    </div>

                    @if($batch->description)
                        <div class="mt-4 bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Description</p>
                            <p class="text-md text-gray-900">{{ $batch->description }}</p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Available From</p>
                            <p class="text-md text-gray-900">{{ $batch->available_from ? $batch->available_from->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-500">Available Until</p>
                            <p class="text-md text-gray-900">{{ $batch->available_until ? $batch->available_until->format('d/m/Y') : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Products</h3>
                    
                    @if(is_array($batch->products) && count($batch->products) > 0)
                    <div class="overflow-x-auto">
                            <table class="min-w-full bg-white border border-gray-300 text-xs">
                                <thead>
                                <tr>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">ID</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Manufacturer</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Model</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Grade</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Tech Grade</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Price</th>
                                        <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">Qty</th>
                                        
                                        @if(is_array($batch->specifications))
                                            @foreach($batch->specifications as $key => $value)
                                                @if(!in_array($key, ['grade', 'visual_grade', 'tech_grade', 'original_specs']))
                                                <th class="px-2 py-2 bg-gray-100 text-left text-xs font-medium text-gray-600 uppercase tracking-wider">{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                                                @endif
                                            @endforeach
                                        @endif
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    @foreach($batch->products as $product)
                                    <tr>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">{{ $product['id'] ?? '-' }}</td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">{{ $product['manufacturer'] }}</td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">{{ $product['model'] }}</td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">{{ $product['grade'] ?? '-' }}</td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs 
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
                                                    text-gray-400
                                                @endif">
                                                {{ $product['tech_grade'] ?? '-' }}
                                                @if(isset($product['problems']) && !empty($product['problems']))
                                                    <span class="block text-gray-500 text-xs italic truncate max-w-xs">{{ $product['problems'] }}</span>
                                                @endif
                                            </td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">@formatPrice($product['price'])</td>
                                            <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">{{ $product['quantity'] }}</td>
                                            
                                            @if(is_array($batch->specifications))
                                                @foreach($batch->specifications as $key => $value)
                                                    @if(!in_array($key, ['grade', 'visual_grade', 'tech_grade', 'original_specs']))
                                                    <td class="px-2 py-2 whitespace-nowrap text-xs text-gray-900">
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
                        <div class="bg-gray-50 p-4 rounded-lg text-center">
                            <p class="text-gray-500">No products in this batch.</p>
                        </div>
                    @endif
                    
                    @if($batch->notes)
                        <div class="mt-6">
                            <h4 class="text-md font-semibold text-gray-800 mb-3">Notes</h4>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-md text-gray-900">{{ $batch->notes }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Images -->
            @if(is_array($batch->images) && count($batch->images) > 0)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Images</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($batch->images as $image)
                                <div class="bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ asset('storage/' . $image) }}" alt="Product Image" class="w-full h-48 object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout> 