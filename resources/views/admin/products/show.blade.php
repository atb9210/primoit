<x-admin-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('admin.products.edit', $product) }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    {{ __('Edit Product') }}
                </a>
                <a href="{{ route('admin.products.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition ease-in-out duration-150">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    {{ __('Back to Products') }}
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

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        <!-- Product Images -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Images</h3>
                            <div class="mb-4 border rounded-lg overflow-hidden h-80">
                                @if($product->images->count() > 0)
                                    <img id="main-image" src="{{ asset('storage/' . $product->primaryImage?->path) }}" alt="{{ $product->name }}" class="w-full h-full object-contain">
                                @else
                                    <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                        <span class="text-gray-400">No image available</span>
                                    </div>
                                @endif
                            </div>
                            
                            @if($product->images->count() > 1)
                                <div class="grid grid-cols-5 gap-2">
                                    @foreach($product->images as $image)
                                        <div class="border rounded cursor-pointer h-20 overflow-hidden {{ $image->is_primary ? 'ring-2 ring-blue-500' : '' }}" 
                                             onclick="document.getElementById('main-image').src='{{ asset('storage/' . $image->path) }}'">
                                            <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        
                        <!-- Product Info -->
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Product Information</h3>
                            
                            <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                    <div class="text-gray-600">ID:</div>
                                    <div class="font-medium">{{ $product->id }}</div>
                                    
                                    <div class="text-gray-600">Name:</div>
                                    <div class="font-medium">{{ $product->name ?? $product->producer . ' ' . $product->model }}</div>
                                    
                                    <div class="text-gray-600">Type:</div>
                                    <div class="font-medium">{{ $product->type }}</div>
                                    
                                    <div class="text-gray-600">Producer:</div>
                                    <div class="font-medium">{{ $product->producer }}</div>
                                    
                                    <div class="text-gray-600">Model:</div>
                                    <div class="font-medium">{{ $product->model }}</div>
                                    
                                    <div class="text-gray-600">Category:</div>
                                    <div class="font-medium">
                                        @if($product->category)
                                            <a href="{{ route('admin.categories.show', $product->category) }}" class="text-blue-600 hover:text-blue-800">
                                                {{ $product->category->name }}
                                            </a>
                                        @else
                                            Uncategorized
                                        @endif
                                    </div>
                                    
                                    <div class="text-gray-600">Status:</div>
                                    <div class="font-medium">{{ ucfirst($product->status ?? 'available') }}</div>
                                    
                                    <div class="text-gray-600">Condition:</div>
                                    <div class="font-medium">{{ ucfirst($product->condition ?? 'used') }}</div>
                                    
                                    <div class="text-gray-600">Quantity:</div>
                                    <div class="font-medium">{{ $product->quantity }}</div>
                                    
                                    <div class="text-gray-600">Price:</div>
                                    <div class="font-medium">@formatPrice($product->price)</div>
                                    
                                    <div class="text-gray-600">Batch Number:</div>
                                    <div class="font-medium">{{ $product->batch_number ?? 'N/A' }}</div>
                                </div>
                            </div>
                            
                            @if($product->description)
                                <div class="bg-gray-50 p-4 rounded-lg mb-6">
                                    <h4 class="font-medium text-gray-800 mb-2">Description</h4>
                                    <p class="text-gray-700">{{ $product->description }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Technical Specifications -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Technical Specifications</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                @if($product->cpu)
                                    <div>
                                        <span class="text-gray-600">CPU:</span>
                                        <span class="font-medium">{{ $product->cpu }}</span>
                                    </div>
                                @endif
                                
                                @if($product->ram)
                                    <div>
                                        <span class="text-gray-600">RAM:</span>
                                        <span class="font-medium">{{ $product->ram }}</span>
                                    </div>
                                @endif
                                
                                @if($product->drive)
                                    <div>
                                        <span class="text-gray-600">Storage:</span>
                                        <span class="font-medium">{{ $product->drive }}</span>
                                    </div>
                                @endif
                                
                                @if($product->operating_system)
                                    <div>
                                        <span class="text-gray-600">OS:</span>
                                        <span class="font-medium">{{ $product->operating_system }}</span>
                                    </div>
                                @endif
                                
                                @if($product->gpu)
                                    <div>
                                        <span class="text-gray-600">GPU:</span>
                                        <span class="font-medium">{{ $product->gpu }}</span>
                                    </div>
                                @endif
                                
                                @if($product->color)
                                    <div>
                                        <span class="text-gray-600">Color:</span>
                                        <span class="font-medium">{{ $product->color }}</span>
                                    </div>
                                @endif
                                
                                @if($product->screen_size)
                                    <div>
                                        <span class="text-gray-600">Screen Size:</span>
                                        <span class="font-medium">{{ $product->screen_size }}</span>
                                    </div>
                                @endif
                                
                                @if($product->lcd_quality)
                                    <div>
                                        <span class="text-gray-600">LCD Quality:</span>
                                        <span class="font-medium">{{ $product->lcd_quality }}</span>
                                    </div>
                                @endif
                                
                                @if($product->battery)
                                    <div>
                                        <span class="text-gray-600">Battery:</span>
                                        <span class="font-medium">{{ $product->battery }}</span>
                                    </div>
                                @endif
                                
                                @if($product->visual_grade)
                                    <div>
                                        <span class="text-gray-600">Visual Grade:</span>
                                        <span class="font-medium">{{ $product->visual_grade }}</span>
                                    </div>
                                @endif
                                
                                <div>
                                    <span class="text-gray-600">Includes Box:</span>
                                    <span class="font-medium">{{ $product->has_box ? 'Yes' : 'No' }}</span>
                                </div>
                            </div>
                            
                            @if($product->info)
                                <div class="mt-4">
                                    <h4 class="font-medium text-gray-800 mb-2">Additional Information</h4>
                                    <p class="text-gray-700">{{ $product->info }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <!-- Batches -->
                    @if($product->batches->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Included in Batches</h3>
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Batch Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reference Code</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Price</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($product->batches as $batch)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $batch->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $batch->reference_code }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                        @if($batch->status === 'active') bg-green-100 text-green-800
                                                        @elseif($batch->status === 'reserved') bg-yellow-100 text-yellow-800
                                                        @elseif($batch->status === 'sold') bg-blue-100 text-blue-800
                                                        @else bg-gray-100 text-gray-800 @endif">
                                                        {{ ucfirst($batch->status) }}
                                                    </span>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $batch->pivot->quantity }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">@formatPrice($batch->pivot->unit_price)</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                                    <a href="{{ route('admin.batches.show', $batch) }}" class="text-indigo-600 hover:text-indigo-900">View Batch</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Additional Specifications -->
                    @if($product->specifications->count() > 0)
                        <div class="mt-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Additional Specifications</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($product->specifications as $spec)
                                        <div>
                                            <span class="text-gray-600">{{ $spec->name }}:</span>
                                            <span class="font-medium">{{ $spec->value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <!-- Danger Zone -->
                    <div class="mt-12 border-t pt-8">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Danger Zone</h3>
                        <div class="bg-red-50 p-4 rounded-lg border border-red-200">
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this product? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Product
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout> 